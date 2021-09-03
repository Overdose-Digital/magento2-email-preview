<?php declare(strict_types=1);

namespace Overdose\PreviewEmail\Model\ResourceModel\PreviewTemplate;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Class Collection
 * @package Overdose\PreviewEmail\Model\ResourceModel\PreviewTemplate
 */
class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(
            \Overdose\PreviewEmail\Model\PreviewTemplate::class,
            \Overdose\PreviewEmail\Model\ResourceModel\PreviewTemplate::class
        );
    }
}
