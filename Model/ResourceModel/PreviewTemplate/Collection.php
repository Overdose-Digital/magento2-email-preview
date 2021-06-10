<?php

namespace Overdose\PreviewEmail\Model\ResourceModel\PreviewTemplate;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Overdose\PreviewEmail\Model\PreviewTemplate as Model;
use Overdose\PreviewEmail\Model\ResourceModel\PreviewTemplate as Resource;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(Model::class, Resource::class);
    }
}
