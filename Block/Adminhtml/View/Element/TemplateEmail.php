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
use Overdose\PreviewEmail\Model\PreviewTemplateRepository;

class TemplateEmail extends Preview
{
    /**
     * @var PreviewTemplateRepository
     */
    public $repository;
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
     * @param PreviewTemplateRepository
     * @param array $data
     */
    public function __construct(
        Context $context,
        MaliciousCode $maliciousCode,
        TemplateFactory $emailFactory,
        Emulation $emulation,
        TemplateData $templateData,
        PreviewTemplateRepository $repository,
        array $data = []
    ) {
        parent::__construct($context, $maliciousCode, $emailFactory, $data);
        $this->emulation = $emulation;
        $this->templateData = $templateData;
        $this->repository = $repository;
    }

    /**
     * Load Template
     * @param int $id
     * @return Template
     */
    public function loadTemplate(int $id)
    {
        $template = $this->_emailFactory->create();
        $emailTemplate = $this->repository->getById($id);
        $templateId = $emailTemplate['template_id'];
        if ($emailTemplate['template_type'] == 'files') {
            $template->setForcedArea($templateId);
            $template->loadDefault($templateId);
            return $template;
        } else {
            $template->load($templateId);
            return $template;
        }
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

}