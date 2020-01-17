<?php


namespace Overdose\PreviewEmail\Model\EmailTemplate;

use Magento\Config\App\Config\Type\System;
use Magento\Email\Model\Template\Config;
use Magento\Framework\Phrase;

class PrepareTemplate
{

    const SCOPE_DEFAULT = 'default';
    /**
     * @var array
     */
    public $pattern = ['customer', 'sales_email'];
    /**
     * @var Config
     */
    protected $emailConfig;
    /**
     * @var System
     */
    protected $_system;

    /**
     * PrepareTemplate constructor.
     * @param System $system
     * @param Config $emailConfig
     */
    public function __construct
    (
        System $system,
        Config $emailConfig
    ) {
        $this->_system = $system;
        $this->emailConfig = $emailConfig;
    }

    /**
     * Prepare Template Data
     * @return array
     */
    public function prepareTemplateData(): array
    {
        $templatesId = $this->prepareTemplateId();
        $availableTemplate = $this->emailConfig->getAvailableTemplates();
        $templatesData = [];
        foreach ($availableTemplate as $template) {
            /** @var Phrase $templateLabel */
            $templateLabel = $template['label'];
            foreach ($templatesId as $templateId) {
                if ($template['value'] === $templateId) {
                    $templatesData[] = ['template_name' => $templateLabel->getText(), 'template_id' => $templateId];
                }
            }
        }
        return $templatesData;
    }

    /**
     * Prepared Template Id from Config
     * @return array
     */
    private function prepareTemplateId(): array
    {
        $configData = $this->getConfigData();
        $data = [];
        foreach ($configData as $sectionLabel => $section) {
            foreach ($this->pattern as $sectionName) {
                if ($sectionLabel === $sectionName) {
                    foreach ($section as $fieldLabel => $field) {
                        if ($sectionLabel === 'customer' || $fieldLabel === 'order' || $fieldLabel === 'order_comment') {
                            foreach ($field as $name => $value) {
                                if (preg_match("!_?template_?!", $name)) {
                                    $data[] = $value;
                                }
                            }
                        }
                    }
                }
            }
        }
        return $data;
    }

    private function getConfigData(): array
    {
        return $this->_system->get(self::SCOPE_DEFAULT);
    }
}