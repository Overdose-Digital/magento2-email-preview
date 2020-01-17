<?php


namespace Overdose\PreviewEmail\Block\Adminhtml\View\Element;

use Exception;
use Magento\Backend\Block\Template\Context;
use Magento\Email\Block\Adminhtml\Template\Preview;
use Magento\Email\Model\AbstractTemplate;
use Magento\Email\Model\Template;
use Magento\Email\Model\TemplateFactory;
use Magento\Framework\Filter\Input\MaliciousCode;
use Magento\Store\Model\App\Emulation;
use Overdose\PreviewEmail\Model\EmailTemplate\TemplateData;


class TemplateEmail extends Preview
{
    /**
     * @var TemplateData
     */
    public $templateData;
    /**
     * @var Emulation
     */
    private $emulation;

    /**
     * @param Context $context
     * @param MaliciousCode $maliciousCode
     * @param TemplateFactory $emailFactory
     * @param Emulation
     * @param TemplateData
     * @param array $data
     */
    public function __construct(
        Context $context,
        MaliciousCode $maliciousCode,
        TemplateFactory $emailFactory,
        Emulation $emulation,
        TemplateData $templateData,
        array $data = []
    ) {
        parent::__construct($context, $maliciousCode, $emailFactory, $data);
        $this->emulation = $emulation;
        $this->templateData = $templateData;
    }

    /**
     * Prepare html output
     * @return string
     * @throws Exception
     */
    protected function _toHtml()
    {
        $request = $this->getRequest();

        $id = $request->getParam('id');

        if (!empty($request->getParam('store_id')) && $request->getParam('store_id') != 'undefined') {
            $storeId = $this->getRequest()->getParam('store_id');
        } else {
            $storeId = $this->getAnyStoreView()->getId();
        }
        $this->emulation->startEnvironmentEmulation($storeId, 'frontend');
        /** @var $template Template */
        $template = $this->loadTemplate($id);
        $emailTemplateVars = $this->templateData->getTemplateData($request->getParams());
        $template->emulateDesign($storeId);

        $template->getProcessedTemplate($emailTemplateVars);
        $templateProcessed = $this->_appState->emulateAreaCode(
            AbstractTemplate::DEFAULT_DESIGN_AREA,
            [$template, 'getProcessedTemplate']
        );

        $templateProcessed = $this->_maliciousCode->filter($templateProcessed);

        if ($template->isPlain()) {
            $templateProcessed = "<pre>" . $this->escapeHtml($templateProcessed) . "</pre>";
        }

        $this->emulation->stopEnvironmentEmulation();
        return $templateProcessed;
    }

    /**
     * Load Template
     * @param $id
     * @return Template
     */
    public function loadTemplate($id)
    {
        $template = $this->_emailFactory->create();
        $template->setForcedArea($id);
        $template->loadDefault($id);
        return $template;
    }

}