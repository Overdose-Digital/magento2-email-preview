<?php


namespace Overdose\PreviewEmail\Model;

use Magento\Customer\Api\CustomerRepositoryInterface as CustomerRepository;
use Magento\Customer\Model\CustomerFactory;
use Magento\Customer\Model\ResourceModel\Customer as Resource;

class Customer
{
    /**
     * @var CustomerRepository
     */
    protected $_customerRepository;
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
     * @param CustomerRepository $customerRepository
     * @param CustomerFactory $customerFactory
     * @param Resource $resource
     */
    public function __construct
    (
        CustomerRepository $customerRepository,
        CustomerFactory $customerFactory,
        Resource $resource
    ) {
        $this->_customerRepository = $customerRepository;
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