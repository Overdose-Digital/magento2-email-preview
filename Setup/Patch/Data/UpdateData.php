<?php declare(strict_types=1);

namespace Overdose\PreviewEmail\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Overdose\PreviewEmail\Model\PreviewTemplateFactory;
use Overdose\PreviewEmail\Model\PreviewTemplateRepository;

/**
 * Class UpdateData
 * @package Overdose\PreviewEmail\Setup\Patch\Data
 */
class UpdateData implements DataPatchInterface
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
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @var PreviewTemplateFactory
     */
    protected $previewTemplateFactory;

    /**
     * @var PreviewTemplateRepository
     */
    protected $previewTemplateRepository;

    /**
     * UpdateData constructor.
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param PreviewTemplateFactory $previewTemplateFactory
     * @param PreviewTemplateRepository $previewTemplateRepository
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        PreviewTemplateFactory $previewTemplateFactory,
        PreviewTemplateRepository $previewTemplateRepository
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->previewTemplateFactory = $previewTemplateFactory;
        $this->previewTemplateRepository = $previewTemplateRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();
        foreach ($this->data as $value) {
            $model = $this->previewTemplateFactory->create();
            $model->addData($value);
            $this->previewTemplateRepository->save($model);
        }
        $this->moduleDataSetup->getConnection()->endSetup();
    }

    /**
     * @return string[]
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * @return string[]
     */
    public function getAliases()
    {
        return [];
    }
}
