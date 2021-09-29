<?php

declare(strict_types=1);

namespace Overdose\PreviewEmail\Block\Adminhtml\View\Element;

use Magento\Backend\Block\Template\Context;
use Magento\Email\Block\Adminhtml\Template\Preview;
use Magento\Email\Model\TemplateFactory;
use Magento\Framework\Filter\Input\MaliciousCode;
use Magento\Store\Model\App\Emulation;
use Overdose\PreviewEmail\Model\ConfigPaths;
use Overdose\PreviewEmail\Model\ResetPassword;
use Overdose\PreviewEmail\Api\PreviewTemplateRepositoryInterface as Repository;
use Overdose\PreviewEmail\Model\Customer;
use Overdose\PreviewEmail\Model\Order;
use Overdose\PreviewEmail\Model\CreditMemo;
use Overdose\PreviewEmail\Model\ContactForm;
use Overdose\PreviewEmail\Model\SubscriptionSuccess;

/**
 * Class TemplateEmail
 * @package Overdose\PreviewEmail\Block\Adminhtml\View\Element
 */
class TemplateEmail extends Preview
{
    /** @var Repository */
    public $previewTemplateRepository;

    /** @var Emulation */
    private $emulation;

    /** @var Order */
    private $orderData;

    /** @var Customer */
    private $customerData;

    /** @var CreditMemo */
    private $creditMemo;

    /** @var ResetPassword */
    private $resetPassword;

    /** @var ContactForm */
    private $contactForm;

    /** @var SubscriptionSuccess */
    private $subscriptionSuccess;

    /**
     * TemplateEmail constructor.
     * @param Context $context
     * @param MaliciousCode $maliciousCode
     * @param TemplateFactory $emailFactory
     * @param Emulation $emulation
     * @param Repository $repository
     * @param Order $order
     * @param Customer $customer
     * @param CreditMemo $creditMemo
     * @param ResetPassword $resetPassword
     * @param ContactForm $contactForm
     * @param SubscriptionSuccess $subscriptionSuccess
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
        CreditMemo $creditMemo,
        ResetPassword $resetPassword,
        ContactForm $contactForm,
        SubscriptionSuccess $subscriptionSuccess,
        array $data = []
    ) {
        parent::__construct($context, $maliciousCode, $emailFactory, $data);
        $this->emulation = $emulation;
        $this->previewTemplateRepository = $repository;
        $this->orderData = $order;
        $this->customerData = $customer;
        $this->creditMemo = $creditMemo;
        $this->resetPassword = $resetPassword;
        $this->contactForm = $contactForm;
        $this->subscriptionSuccess = $subscriptionSuccess;
    }

    /**
     * @inheritDoc
     */
    protected function _toHtml()
    {
        $request = $this->getRequest();
        $previewTemplate = $this->previewTemplateRepository->getById((int)$request->getParam('preview_template_id'));
        $data = $this->getEntityId($request->getParams());
        $entityId = (int)$data['entityId'];
        $type = $data['type'];

        $templatePathInConfig = $this->fetchTemplateIdentifierUsingField($type, $entityId);
        $id = $this->_scopeConfig->getValue($templatePathInConfig);

        $storeParam = $request->getParam('store_id');
        if (isset($storeParam) && $request->getParam('store_id') != 'undefined') {
            $storeId = $this->getRequest()->getParam('store_id');
        } else {
            $storeId = $this->getAnyStoreView()->getId();
        }
        $this->emulation->startEnvironmentEmulation($storeId, 'frontend');
        /** @var $template \Magento\Email\Model\Template */
        $template = $this->loadTemplate($id);
        $emailTemplateVars = $this->getTemplateData($previewTemplate->getType(), $request->getParams());
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

    /**
     * @param $fields
     * @param $requestId
     * @return array
     */
    private function getTemplateData($type, $requestId): array
    {
        switch ($type) {
            case 'order':
            case 'shipment':
            case 'invoice':
                if (isset($requestId['order_id']) && $requestId['order_id'] != 'undefined') {
                    $templateData = $this->orderData->getVars($requestId['order_id']);
                }
                break;
            case 'customer':
                if (isset($requestId['customer_id']) && $requestId['customer_id'] != 'undefined') {
                    $templateData = $this->customerData->getVars($requestId['customer_id']);
                }
                break;
            case 'creditmemo':
                if (isset($requestId['creditmemo_id']) && $requestId['creditmemo_id'] != 'undefined') {
                    $templateData = $this->creditMemo->getVars($requestId['creditmemo_id']);
                }
                break;
            case 'password_reset':
                if (isset($requestId['password_reset']) && $requestId['password_reset'] != 'undefined') {
                    $templateData = $this->resetPassword->getVars((int)$requestId['password_reset']);
                }
                break;
            case 'contact_form':
                if (isset($requestId['contact_form']) && $requestId['contact_form'] != 'undefined') {
                    $templateData = $this->contactForm->getVars((int)$requestId['contact_form']);
                }
                break;
            case 'subscription_success':
                if (isset($requestId['subscription_success']) && $requestId['subscription_success'] != 'undefined') {
                    $templateData = $this->subscriptionSuccess->getVars((int)$requestId['subscription_success']);
                }
                break;
            default:
                $templateData = [];
        }
        return empty($templateData) ? $templateData = [] : $templateData;
    }

    /**
     * @param array $requestId
     * @return array
     */
    private function getEntityId(array $requestId): array
    {
        $entityId = null;
        $type = null;
        if (isset($requestId['order_id']) && $requestId['order_id'] != 'undefined') {
            $entityId = $requestId['order_id'];
            $type = 'order';
        } else if (isset($requestId['customer_id']) && $requestId['customer_id'] != 'undefined') {
            $entityId = $requestId['customer_id'];
            $type = 'customer';
        } else if (isset($requestId['creditmemo_id']) && $requestId['creditmemo_id'] != 'undefined') {
            $entityId = $requestId['creditmemo_id'];
            $type = 'creditmemo';
        } else if (isset($requestId['password_reset']) && $requestId['password_reset'] != 'undefined') {
            $entityId = $requestId['password_reset'];
            $type = 'password_reset';
        } else if (isset($requestId['contact_form']) && $requestId['contact_form'] != 'undefined') {
            $entityId = $requestId['contact_form'];
            $type = 'contact_form';
        } else if (isset($requestId['subscription_success']) && $requestId['subscription_success'] != 'undefined') {
            $entityId = $requestId['subscription_success'];
            $type = 'subscription_success';
        }
        return ['entityId' => $entityId, 'type' => $type];
    }

    /**
     * @param string $type
     * @param int $entityId
     * @return string
     */
    private function fetchTemplateIdentifierUsingField(string $type, int $entityId): string
    {
        switch ($type) {
            case 'order':
                $order = $this->orderData->getOrderById($entityId);
                if ($order->getCustomerIsGuest())
                    return ConfigPaths::guestOrderConfirmationEmailConfigPath();
                return ConfigPaths::orderConfirmationEmailConfigPath();
            case 'invoice':
                $order = $this->orderData->getOrderById($entityId);
                if ($order->getCustomerIsGuest())
                    return ConfigPaths::guestInvoiceEmailConfigPath();
                return ConfigPaths::invoiceEmailConfigPath();
            case 'shipment':
                $order = $this->orderData->getOrderById($entityId);
                if ($order->getCustomerIsGuest())
                    return ConfigPaths::guestShipmentEmailConfigPath();
                return ConfigPaths::shipmentEmailConfigPath();
            case 'creditmemo':
                $order = $this->orderData->getOrderById($entityId);
                if ($order->getCustomerIsGuest())
                    return ConfigPaths::guestCreditMemoEmailConfigPath();
                return ConfigPaths::creditMemoEmailConfigPath();
            case 'customer':
                return ConfigPaths::registerEmailTemplate();
            case 'password_reset':
                return ConfigPaths::resetPasswordEmailTemplate();
            case 'contact_form':
                return ConfigPaths::contactFormEmailTemplate();
            case 'subscription_success':
                return ConfigPaths::subscriptionSuccessEmailTemplate();
            default:
                return '';
        }
    }
}
