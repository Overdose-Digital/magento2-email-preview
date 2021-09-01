<?php declare(strict_types=1);

namespace Overdose\PreviewEmail\Block\Adminhtml\View\Element;

use Magento\Backend\Block\Template;
use Magento\Backend\Block\Template\Context;
use Magento\Customer\Model\ResourceModel\Customer\CollectionFactory as CustomerCollection;
use Magento\Framework\Data\Form\FormKey;
use Magento\Sales\Model\Order;
use Magento\Sales\Model\ResourceModel\Order\Collection;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactory;
use Magento\Store\Model\StoreRepository;
use Magento\Store\Api\Data\StoreInterface;

/**
 * Class Form
 * @package Overdose\PreviewEmail\Block\Adminhtml\View\Element
 */
class Form extends Template
{
    /** @var Collection */
    public $orderCollection;

    /** @var \Magento\Customer\Model\ResourceModel\Customer\Collection */
    public $customers;

    /** @var StoreRepository */
    public $storeRepository;

    /** @var FormKey */
    protected $formKey;

    /**
     * Form constructor.
     * @param Context $context
     * @param CollectionFactory $collectionFactory
     * @param FormKey $formKey
     * @param StoreRepository $storeRepository
     * @param CustomerCollection $customerFactory
     * @param array $data
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
     * @return array
     */
    public function getOrderIds(): array
    {
        $orders = [];
        /** @var Order $order */
        foreach ($this->orderCollection as $order) {
            $orders[] = $order->getIncrementId();
        }
        return $orders;
    }

    /**
     * @return array
     */
    public function getStores(): array
    {
        /** @var StoreInterface[] $storesList */
        $storesList = $this->storeRepository->getList();
        $stores = [];

        /** @var StoreInterface $store */
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

    public function getOptionType()
    {
        return $this->getRequest()->getParam('type');
    }
}
