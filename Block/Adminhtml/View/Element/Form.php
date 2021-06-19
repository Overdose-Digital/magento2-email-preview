<?php
declare(strict_types=1);

namespace Overdose\PreviewEmail\Block\Adminhtml\View\Element;

use Magento\Backend\Block\Template;
use Magento\Backend\Block\Template\Context;
use Magento\Customer\Model\ResourceModel\Customer\CollectionFactory as CustomerCollection;
use Magento\Framework\Data\Form\FormKey;
use Magento\Sales\Model\Order;
use Magento\Sales\Model\ResourceModel\Order\Collection;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactory;
use Magento\Store\Model\StoreRepository;

class Form extends Template
{
    /**
     * @var Collection
     */
    public $orderCollection;
    /**
     * @var StoreRepository
     */

    public $customers;
    /**
     * @var StoreRepository
     */
    public $storeRepository;
    /**
     * @var FormKey
     */
    /**
     * @var FormKey
     */
    protected $formKey;

    /**
     * Form constructor.
     * @param Context $context
     * @param array $data
     * @param CollectionFactory $collectionFactory
     * @param FormKey $formKey
     * @param StoreRepository $storeRepository
     * @param CustomerCollection $customerFactory
     */
    public function __construct
    (
        Context $context,
        CollectionFactory $collectionFactory,
        FormKey $formKey,
        StoreRepository $storeRepository,
        CustomerCollection $customerFactory,
        array $data = []
    ) {
        $this->formKey = $formKey;
        $this->customers = $customerFactory->create();
        $this->storeRepository = $storeRepository;
        $this->orderCollection = $collectionFactory->create();
        parent::__construct($context, $data);
    }

    public function getPreviewTemplateId()
    {
        return $this->getRequest()->getParam('id');
    }

    /**
     * Get Order Ids
     * @return array
     */
    public function getOrderIds()
    {
        $orders = [];
        foreach ($this->orderCollection as $order) {
            /** @var Order $order */
            $orders[] = $order->getIncrementId();
        }

        return $orders;
    }

    /**
     * Return Stores Name and Id
     * @return array
     */
    public function getStores()
    {
        $storesList = $this->storeRepository->getList();
        $stores = [];
        foreach ($storesList as $store) {
            $stores[$store->getId()] = $store->getName();
        }
        return $stores;
    }

    /**
     * Get Customer Full Name
     * @return array
     */
    public function getCustomersFullName()
    {
        $customersFullName = [];
        foreach ($this->customers->getData() as $customer) {
            $firstName = $customer['firstname'];
            $lastName = $customer['lastname'];
            $customersFullName[$customer['entity_id']] = "$firstName $lastName";
        }
        return $customersFullName;
    }

    public function getOptionType()
    {
        return $this->getRequest()->getParam('type');
    }
}
