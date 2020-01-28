<?php


namespace Overdose\PreviewEmail\Setup;

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\UpgradeDataInterface;
use Overdose\PreviewEmail\Model\PreviewTemplateFactory;
use Overdose\PreviewEmail\Model\PreviewTemplateRepository;

class UpgradeData implements UpgradeDataInterface
{
    public $data = [
        [
            'type' => 'order',
            'fields' => 'order',
            'name' => 'New Order Confirmation Template',
            'config_path' => 'sales_email/order/template'
        ],
        [
            'type' => 'invoice',
            'fields' => 'order',
            'name' => 'Invoice Email Template',
            'config_path' => 'sales_email/invoice/template'
        ],
        [
            'type' => 'customer',
            'fields' => 'customer',
            'name' => 'Default Welcome Email',
            'config_path' => 'customer/create_account/email_template'
        ]
    ];
    /**
     * @var PreviewTemplateFactory
     */

    /**
     * @var PreviewTemplateRepository
     */
    public $repository;

    /**
     * UpgradeData constructor.
     * @param PreviewTemplateRepository
     */
    public function __construct
    (
        PreviewTemplateFactory $previewTemplateFactory,
        PreviewTemplateRepository $repository
    ) {
        $this->previewTemplateFactory = $previewTemplateFactory;
        $this->repository = $repository;
    }

    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        if (version_compare($context->getVersion(), '1.1.0', '<')) {

            foreach ($this->data as $value) {
                $model = $this->previewTemplateFactory->create();
                $model->addData($value);
                $this->repository->save($model);
            }
        }
    }
}