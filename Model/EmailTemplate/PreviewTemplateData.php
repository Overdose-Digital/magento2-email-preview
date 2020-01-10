<?php
declare(strict_types=1);

namespace Overdose\PreviewEmail\Model\EmailTemplate;

use Magento\Email\Model\ResourceModel\Template\CollectionFactory;
use Magento\Email\Model\Template\Config;

class PreviewTemplateData
{
    const FROM_FILES = 'files';

    const WITH_TABLE = 'table';
    /**
     * @var array
     */
    public $prepareDataName = ['customer', 'sales'];
    /**
     * @var Config
     */
    public $emailConfig;
    /**
     * @var CollectionFactory
     */
    public $collectionFactory;

    /**
     * PreviewTemplateData constructor.
     * @param CollectionFactory $collectionFactory
     * @param Config $emailConfig
     */
    public function __construct
    (
        CollectionFactory $collectionFactory,
        Config $emailConfig
    ) {
        $this->emailConfig = $emailConfig;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * Preparing Template Data
     *
     * @return array
     */
    public function prepareTemplateData()
    {
        $templateConfig = $this->prepareTemplateConfig();
        $data = [];
        foreach ($templateConfig as $template) {
            /** @var \Magento\Framework\Phrase $templateLabel */
            $templateLabel = $template['label'];
            if (is_object($templateLabel)) {
                $templateName = $templateLabel->getText();
            } else {
                $templateName = $templateLabel;
            }
            $data[] =
                [
                    'template_id' => $template['value'],
                    'template_name' => $templateName,
                    'template_type' => self::FROM_FILES
                ];

        }

        $templateEmail = $this->prepareTemplateEmail();
        foreach ($templateEmail as $template) {
            $data[] = $template;
        }
        return $data;
    }

    /**
     * Preparing email template from config
     * @return array
     */
    protected function prepareTemplateConfig()
    {
        $availableTemplate = $this->emailConfig->getAvailableTemplates();
        $dataTemplate = [];
        foreach ($this->prepareDataName as $name) {
            $prefix = 'Magento';
            $prepareName = $prefix . '_' . ucfirst($name);
            foreach ($availableTemplate as $templateData) {
                if ($templateData['group'] == $prepareName) {
                    $dataTemplate[] = $templateData;
                }
            }
        }


        return $dataTemplate;
    }

    /**
     * Preparing email template with table
     * @return array
     */
    protected function prepareTemplateEmail()
    {
        $collection = $this->collectionFactory->create();
        $data = [];
        foreach ($collection->getData() as $key => $value) {
            if (!empty($value)) {
                foreach ($this->prepareDataName as $name) {
                    if (preg_match("!_?$name?!", $value['orig_template_code'])) {
                        $data[] =
                            [
                                'template_id' => $value['template_id'],
                                'template_name' => $value['template_code'],
                                'template_type' => self::WITH_TABLE
                            ];

                    }
                }
            }
        }
        return $data;
    }
}