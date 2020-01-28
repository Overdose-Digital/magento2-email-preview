<?php


namespace Overdose\PreviewEmail\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;
use Overdose\PreviewEmail\Api\Data\PreviewTemplateInterface as Config;

class PreviewTemplate extends AbstractDb
{
    public function __construct(Context $context, $connectionName = null)
    {
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