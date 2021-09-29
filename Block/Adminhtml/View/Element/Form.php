<?php

declare(strict_types=1);

namespace Overdose\PreviewEmail\Block\Adminhtml\View\Element;

use Magento\Backend\Block\Template\Context;
use Magento\Customer\Model\ResourceModel\Customer\CollectionFactory as CustomerCollection;
use Magento\Framework\Data\Form\FormKey;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactory;
use Magento\Store\Model\StoreRepository;
use Magento\Newsletter\Model\SubscriberFactory;

/**
 * Class Form
 * @package Overdose\PreviewEmail\Block\Adminhtml\View\Element
 */
class Form extends \Magento\Backend\Block\Template
{
    /** @var \Magento\Sales\Model\ResourceModel\Order\Collection */
    public $orderCollection;

    /** @var \Magento\Customer\Model\ResourceModel\Customer\Collection */
    public $customers;

    /** @var StoreRepository */
    public $storeRepository;

    /** @var FormKey */
    protected $formKey;

    /** @var SubscriberFactory */
    private $subscriptionFactory;

    /**
     * Form constructor.
     * @param Context $context
     * @param CollectionFactory $collectionFactory
     * @param FormKey $formKey
     * @param StoreRepository $storeRepository
     * @param CustomerCollection $customerFactory
     * @param array $data
     */
    public function __construct(
        Context $context,
        CollectionFactory $collectionFactory,
        FormKey $formKey,
        StoreRepository $storeRepository,
        CustomerCollection $customerFactory,
        SubscriberFactory $subscriberFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->formKey = $formKey;
        $this->customers = $customerFactory->create();
        $this->storeRepository = $storeRepository;
        $this->orderCollection = $collectionFactory->create();
        $this->subscriptionFactory = $subscriberFactory;
    }

    public function getPreviewTemplateId()
    {
        return $this->getRequest()->getParam('id');
    }

    /**
     * @return array
     */
    public function getOrderIds(): array
    {
        $orders = [];
        /** @var \Magento\Sales\Model\Order $order */
        foreach ($this->orderCollection as $order) {
            $orders[] = $order->getIncrementId();
        }
        return $orders;
    }

    /**
     * @return \Magento\Sales\Model\ResourceModel\Order\Collection
     */
    public function getOrders(): \Magento\Sales\Model\ResourceModel\Order\Collection
    {
        return $this->orderCollection;
    }

    /**
     * @return array
     */
    public function getStores(): array
    {
        /** @var \Magento\Store\Api\Data\StoreInterface[] $storesList */
        $storesList = $this->storeRepository->getList();
        $stores = [];

        /** @var \Magento\Store\Api\Data\StoreInterface $store */
        foreach ($storesList as $store) {
            $stores[$store->getId()] = $store->getName();
        }
        return $stores;
    }

    /**
     * @return array
     */
    public function getCustomersFullName(): array
    {
        $customersFullName = [];
        foreach ($this->customers->getData() as $customer) {
            $firstName = $customer['firstname'];
            $lastName = $customer['lastname'];
            $customersFullName[$customer['entity_id']] = "$firstName $lastName";
        }
        return $customersFullName;
    }

    /**
     * @return string
     */
    public function getOptionType(): string
    {
        return $this->getRequest()->getParam('type');
    }

    /**
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getSubscribedCustomers(): array
    {
        $subscribedCustomers = [];

        /** @var \Magento\Customer\Model\Customer $customer */
        foreach ($this->customers->getItems() as $customer)
        {
            /** @var \Magento\Newsletter\Model\Subscriber $subscriber */
            $subscriber = $this->subscriptionFactory->create();
            $checkSubscriber = $subscriber->loadByEmail($customer->getEmail());
            if ($checkSubscriber->isSubscribed()) {
                $subscribedCustomers[$customer->getEntityId()] = $customer->getName();
            }
        }
        return $subscribedCustomers;
    }
}
