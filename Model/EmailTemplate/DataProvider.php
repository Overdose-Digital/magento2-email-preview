<?php


namespace Overdose\PreviewEmail\Model\EmailTemplate;

use Magento\Email\Model\Template\Config;

class DataProvider
{
    /**
     * @var Config
     */
    public $emailConfig;

    /**
     * DataProvider constructor.
     * @param Config $emailConfig
     */
    public function __construct(Config $emailConfig)
    {
        $this->emailConfig = $emailConfig;
    }

    /**
     * @return array
     */
    public function getTemplateConfig()
    {
        $options = array_merge(
            [['value' => '', 'label' => '', 'group' => '']],
            $this->emailConfig->getAvailableTemplates()
        );
        uasort(
            $options,
            function (array $firstElement, array $secondElement) {
                return strcmp($firstElement['label'], $secondElement['label']);
            }
        );

        return $options;
    }
}