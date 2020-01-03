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
    public $collection;
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

    protected $formKey;

    public function __construct
    (
        Context $context,
        array $data = [],
        CollectionFactory $collectionFactory,
        FormKey $formKey,
        StoreRepository $storeRepository,
        CustomerCollection $customerFactory
    ) {
        $this->formKey = $formKey;
        $this->customers = $customerFactory->create();
        $this->storeRepository = $storeRepository;
        $this->collection = $collectionFactory->create();
        parent::__construct($context, $data);
    }

    /**
     *
     */
    public function getTemplateId()
    {
        return $this->getRequest()->getParam('template_id');
    }

    /**Return Order Id
     *
     * @return array
     */
    public function getOrderId()
    {
        $orders = [];
        foreach ($this->collection as $order) {
            /** @var Order $order */
            $orders[] = $order->getIncrementId();
        }

        return $orders;
    }

    /**Return Stores Name and Id
     *
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

}