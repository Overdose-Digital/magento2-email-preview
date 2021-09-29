<?php

declare(strict_types=1);

namespace Overdose\PreviewEmail\Api\Data;

use Overdose\PreviewEmail\Api\Data\PreviewTemplateInterface;

/**
 * Interface PreviewTemplateSearchResultInterface
 * @package Overdose\PreviewEmail\Api\Data
 */
interface PreviewTemplateSearchResultInterface
{
    /**
     * @return PreviewTemplateInterface[]
     */
    public function getItems();

    /**
     * @param PreviewTemplateInterface[] $items
     * @return mixed
     */
    public function setItems(array $items);
}
