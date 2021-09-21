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
            'name' => 'New Order Confirmation Email Template'
        ],
        [
            'type' => 'invoice',
            'name' => 'Invoice Email Template'
        ],
        [
            'type' => 'customer',
            'name' => 'Default Welcome Email Template'
        ],
        [
            'type' => 'shipment',
            'name' => 'Shipment Email Template'
        ],
        [
            'type' => 'creditmemo',
            'name' => 'CreditMemo Email Template'
        ],
        [
            'type' => 'password_reset',
            'name' => 'Reset Customer Password Email Template'
        ],
        [
            'type' => 'contact_form',
            'name' => 'Contact Form Email Template'
        ],
        [
            'type' => 'subscription_success',
            'name' => 'Subscription Success Email Template'
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
