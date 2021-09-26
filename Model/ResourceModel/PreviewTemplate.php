<?php

declare(strict_types=1);

namespace Overdose\PreviewEmail\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;
use Overdose\PreviewEmail\Api\Data\PreviewTemplateInterface as Config;

/**
 * Class PreviewTemplate
 * @package Overdose\PreviewEmail\Model\ResourceModel
 */
class PreviewTemplate extends AbstractDb
{
    /**
     * PreviewTemplate constructor.
     * @param Context $context
     * @param null $connectionName
     */
    public function __construct (
        Context $context,
        $connectionName = null
    ) {
        parent::__construct($context, $connectionName);
    }

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(Config::TABLE_NAME, Config::ID);
    }
}
