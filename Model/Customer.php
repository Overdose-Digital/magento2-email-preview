<?php

namespace Overdose\PreviewEmail\Model;

use Magento\Customer\Model\CustomerFactory;
use Magento\Customer\Model\ResourceModel\Customer as Resource;

class Customer
{
    /**
     * @var CustomerFactory
     */
    protected $customerFactory;
    /**
     * @var Resource
     */
    protected $resource;

    /**
     * Customer constructor.
     * @param CustomerFactory $customerFactory
     * @param Resource $resource
     */
    public function __construct
    (
        CustomerFactory $customerFactory,
        Resource $resource
    ) {
        $this->customerFactory = $customerFactory;
        $this->resource = $resource;
    }

    /**
     * Get Customer Vars
     * @param $id
     * @return array
     */

    public function getVars($id)
    {
        $customer = $this->customerFactory->create();
        $this->resource->load($customer, $id);
        $vars = [
            'customer' => $customer,
        ];
        return $vars;
    }
}
