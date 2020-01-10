<?php
declare(strict_types=1);

namespace Overdose\PreviewEmail\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;
use Overdose\PreviewEmail\Model\PreviewTemplate as Config;

class PreviewTemplate extends AbstractDb
{
    public function __construct(Context $context, ?string $connectionName = null)
    {
        parent::__construct($context, $connectionName);
    }

    /**
     * Resource initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(Config::TABLE_NAME, Config::ID);
    }
}