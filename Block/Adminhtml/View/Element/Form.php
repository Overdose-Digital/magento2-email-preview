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
use Overdose\PreviewEmail\Model\EmailTemplate\PrepareTemplate;

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
    /**
     * @var FormKey
     */
    protected $formKey;
    /**
     * @var PrepareTemplate
     */
    protected $prepareTemplate;

    /**
     * Form constructor.
     * @param Context $context
     * @param array $data
     * @param CollectionFactory $collectionFactory
     * @param FormKey $formKey
     * @param StoreRepository $storeRepository
     * @param CustomerCollection $customerFactory
     * @param PrepareTemplate $prepareTemplate
     */
    public function __construct
    (
        Context $context,
        CollectionFactory $collectionFactory,
        FormKey $formKey,
        StoreRepository $storeRepository,
        CustomerCollection $customerFactory,
        PrepareTemplate $prepareTemplate,
        array $data = []

    ) {
        $this->formKey = $formKey;
        $this->customers = $customerFactory->create();
        $this->storeRepository = $storeRepository;
        $this->collection = $collectionFactory->create();
        $this->prepareTemplate = $prepareTemplate;
        parent::__construct($context, $data);
    }

    /**
     *Return Order Id
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

    /**
     *Return Stores Name and Id
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
     *Get Customer Full Name
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

    /**
     *
     */
    public function getPreparedTemplate()
    {
        $this->prepareTemplate->prepareTemplate();
        $this->prepareTemplate->setTemplateName();

    }

    /**
     * @return array
     */
    public function getTemplateData()
    {
        return $this->prepareTemplate->prepareTemplateData();
    }
}