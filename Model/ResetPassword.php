<?php declare(strict_types=1);

namespace Overdose\PreviewEmail\Model;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Customer\Model\CustomerRegistry;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Customer\Helper\View as CustomerViewHelper;

/**
 * Class CreditMemo
 * @package Overdose\PreviewEmail\Model
 */
class ResetPassword implements \Overdose\PreviewEmail\Api\Data\PreviewTemplateVaribles
{
    /** @var CustomerRepositoryInterface */
    private $customerRepository;

    /** @var CustomerRegistry */
    private $customerRegistry;

    /** @var DataObjectProcessor */
    private $dataObjectProcessor;

    /** @var CustomerViewHelper */
    private $customerViewHelper;

    /**
     * ResetPassword constructor.
     * @param CustomerRepositoryInterface $customerRepository
     * @param CustomerRegistry $customerRegistry
     * @param DataObjectProcessor $dataObjectProcessor
     * @param CustomerViewHelper $customerViewHelper
     */
    public function __construct(
        CustomerRepositoryInterface $customerRepository,
        CustomerRegistry $customerRegistry,
        DataObjectProcessor $dataObjectProcessor,
        CustomerViewHelper $customerViewHelper
    ) {
        $this->customerRepository = $customerRepository;
        $this->customerRegistry = $customerRegistry;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->customerViewHelper = $customerViewHelper;
    }

    /**
     * @param int $customerId
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getVars(int $customerId): array
    {
        /** @var CustomerInterface $customer */
        $customer = $this->getCustomerById($customerId);
        /** @var \Magento\Customer\Model\Data\CustomerSecure $customerEmailData */
        $customerEmailData = $this->getFullCustomerObject($customer);

        return ['customer' => $customerEmailData];
    }

    /**
     * @param int $customerId
     * @return CustomerInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    private function getCustomerById(int $customerId): CustomerInterface
    {
        return $this->customerRepository->getById($customerId);
    }

    /**
     * Create an object with data merged from Customer and CustomerSecure
     *
     * @param CustomerInterface $customer
     * @return \Magento\Customer\Model\Data\CustomerSecure
     */
    private function getFullCustomerObject($customer)
    {
        // No need to flatten the custom attributes or nested objects since the only usage is for email templates and
        // object passed for events
        $mergedCustomerData = $this->customerRegistry->retrieveSecureData($customer->getId());
        $customerData = $this->dataObjectProcessor
            ->buildOutputDataArray($customer, CustomerInterface::class);
        $mergedCustomerData->addData($customerData);
        $mergedCustomerData->setData('name', $this->customerViewHelper->getCustomerName($customer));
        return $mergedCustomerData;
    }
}
