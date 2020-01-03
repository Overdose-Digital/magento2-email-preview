<?php
declare(strict_types=1);

namespace Overdose\PreviewEmail\Model\EmailTemplate;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Sales\Api\OrderRepositoryInterface;

class TemplateData
{
    /**
     * @var OrderRepositoryInterface
     */
    protected $orderRepository;
    /**
     * @var CustomerRepositoryInterface
     */
    protected $customerRepository;

    /**
     * TemplateData constructor.
     * @param OrderRepositoryInterface $orderRepository
     * @param CustomerRepositoryInterface $customerRepository
     */
    public function __construct
    (
        OrderRepositoryInterface $orderRepository,
        CustomerRepositoryInterface $customerRepository
    ) {
        $this->orderRepository = $orderRepository;
        $this->customerRepository = $customerRepository;
    }

    /**
     * Get template data by template original code
     *
     * @param array $request
     * @return array
     */
    public function getTemplateData
    (
        array $request
    ) {
        $templateData = [];
        foreach ($request as $key => $value) {
            if (!empty($value) && $value != 'undefined') {
                switch ($key) {
                    case 'order_id':
                        $templateData['order'] = $this->orderRepository->get($request['order_id']);
                        break;
                    case 'customer_id':
                        $templateData['customer'] = $this->customerRepository->getById($request['customer_id']);
                        break;
                }
            }
        }
        return $templateData;
    }
}