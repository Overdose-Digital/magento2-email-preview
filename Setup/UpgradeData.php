<?php
declare(strict_types=1);

namespace Overdose\PreviewEmail\Setup;

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\UpgradeDataInterface;
use Overdose\PreviewEmail\Model\EmailTemplate\PreviewTemplateData;
use Overdose\PreviewEmail\Model\PreviewTemplateFactory;
use Overdose\PreviewEmail\Model\PreviewTemplateRepository;

class UpgradeData implements UpgradeDataInterface
{
    /**
     * @var PreviewTemplateFactory
     */
    public $previewTemplateFactory;
    /**
     * @var PreviewTemplateData
     */
    public $templateData;
    /**
     * @var PreviewTemplateRepository
     */
    public $repository;

    /**
     * UpgradeData constructor.
     * @param PreviewTemplateFactory $previewTemplateFactory
     * @param PreviewTemplateData $templateData
     * @param PreviewTemplateRepository
     */
    public function __construct
    (
        PreviewTemplateFactory $previewTemplateFactory,
        PreviewTemplateData $templateData,
        PreviewTemplateRepository $repository
    ) {
        $this->previewTemplateFactory = $previewTemplateFactory;
        $this->templateData = $templateData;
        $this->repository = $repository;
    }

    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        if (version_compare($context->getVersion(), '1.1.0', '<')) {

            $data = $this->templateData->prepareTemplateData();
            foreach ($data as $value) {
                $model = $this->previewTemplateFactory->create();
                $model->addData($value);
                $this->repository->save($model);
            }
        }
    }
}