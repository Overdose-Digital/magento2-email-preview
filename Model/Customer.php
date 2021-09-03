<?php declare(strict_types=1);

namespace Overdose\PreviewEmail\Model;

use Magento\Customer\Model\CustomerFactory;
use Magento\Customer\Model\ResourceModel\Customer as Resource;

/**
 * Class Customer
 * @package Overdose\PreviewEmail\Model
 */
class Customer
{
    /** @var CustomerFactory */
    protected $customerFactory;

    /** @var Resource */
    protected $resource;

    /**
     * Customer constructor.
     * @param CustomerFactory $customerFactory
     * @param Resource $resource
     */
    public function __construct (
        CustomerFactory $customerFactory,
        Resource $resource
    ) {
        $this->customerFactory = $customerFactory;
        $this->resource = $resource;
    }

    /**
     * @param $id
     * @return array
     */
    public function getVars($id): array
    {
        /** @var \Magento\Customer\Model\Customer $customer */
        $customer = $this->customerFactory->create();
        $this->resource->load($customer, $id);
        $vars = ['customer' => $customer];
        return $vars;
    }
}
