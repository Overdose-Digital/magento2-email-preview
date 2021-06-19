<?php

namespace Overdose\PreviewEmail\Block\Adminhtml\View\Element;

use Magento\Backend\Block\Template\Context;
use Magento\Email\Block\Adminhtml\Template\Preview;
use Magento\Email\Model\TemplateFactory;
use Magento\Framework\Filter\Input\MaliciousCode;
use Magento\Store\Model\App\Emulation;
use Overdose\PreviewEmail\Api\PreviewTemplateRepositoryInterface as Repository;
use Overdose\PreviewEmail\Model\Customer;
use Overdose\PreviewEmail\Model\Order;

class TemplateEmail extends Preview
{
    /**
     * @var Repository
     */
    public $previewTemplateRepository;
    /**
     * @var Emulation
     */
    private $emulation;
    /**
     * @var Order
     */
    private $orderData;

    private $customerData;

    /**
     * @param Context $context
     * @param MaliciousCode $maliciousCode
     * @param TemplateFactory $emailFactory
     * @param Emulation
     * @param Repository
     * @param array $data
     */
    public function __construct(
        Context $context,
        MaliciousCode $maliciousCode,
        TemplateFactory $emailFactory,
        Emulation $emulation,

        Repository $repository,
        Order $order,
        Customer $customer,
        array $data = []
    ) {
        parent::__construct($context, $maliciousCode, $emailFactory, $data);
        $this->emulation = $emulation;
        $this->previewTemplateRepository = $repository;
        $this->orderData = $order;
        $this->customerData = $customer;
    }

    /**
     * Prepare html output
     * @return string
     * @throws \Exception
     */
    protected function _toHtml()
    {
        $request = $this->getRequest();
        $previewTemplate = $this->previewTemplateRepository->getById($request->getParam('preview_template_id'));
        $id = $this->_scopeConfig->getValue($previewTemplate->getConfigPath());

        if (!empty($request->getParam('store_id')) && $request->getParam('store_id') != 'undefined') {
            $storeId = $this->getRequest()->getParam('store_id');
        } else {
            $storeId = $this->getAnyStoreView()->getId();
        }
        $this->emulation->startEnvironmentEmulation($storeId, 'frontend');
        /** @var $template \Magento\Email\Model\Template */
        $template = $this->loadTemplate($id);
        $emailTemplateVars = $this->getTemplateData($previewTemplate->getFields(), $request->getParams());
        $template->getProcessedTemplate($emailTemplateVars);
        $templateProcessed = $this->_appState->emulateAreaCode(
            \Magento\Email\Model\AbstractTemplate::DEFAULT_DESIGN_AREA,
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
     * @return \Magento\Email\Model\Template
     */
    public function loadTemplate($id)
    {
        $template = $this->_emailFactory->create();
        $template->setForcedArea($id);
        $template->loadDefault($id);
        return $template;
    }

    private function getTemplateData($fields, $requestId)
    {
        $typeData = explode(',', $fields);
        foreach ($typeData as $value) {
            switch ($value) {
                case 'order':
                    if (!empty($requestId['order_id']) && $requestId['order_id'] != 'undefined') {
                        $templateData = $this->orderData->getVars($requestId['order_id']);
                    }
                    break;
                case 'customer':
                    if (!empty($requestId['customer_id']) && $requestId['customer_id'] != 'undefined') {
                        $templateData = $this->customerData->getVars($requestId['customer_id']);
                    }
                    break;
                default:
                    $templateData = [];
            }
        }
        return empty($templateData) ? $templateData = [] : $templateData;
    }
}
