<?php declare(strict_types=1);

namespace Overdose\PreviewEmail\Block\Adminhtml\View\Element;

use Magento\Backend\Block\Template\Context;
use Magento\Customer\Model\ResourceModel\Customer\CollectionFactory as CustomerCollection;
use Magento\Framework\Data\Form\FormKey;
use Magento\Sales\Model\ResourceModel\Order\Collection;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactory;
use Magento\Store\Model\StoreRepository;

/**
 * Class Form
 * @package Overdose\PreviewEmail\Block\Adminhtml\View\Element
 */
class Form extends \Magento\Backend\Block\Template
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
    public function __construct(
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
        /** @var \Magento\Sales\Model\Order $order */
        foreach ($this->orderCollection as $order) {
            $orders[] = $order->getIncrementId();
        }
        return $orders;
    }

    /**
     * @return Collection
     */
    public function getOrders(): Collection
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
}
