<?php

declare(strict_types=1);

namespace Overdose\PreviewEmail\Api\Data;

/**
 * Interface PreviewTemplateVaribles
 * @package Overdose\PreviewEmail\Api\Data
 */
interface PreviewTemplateVaribles
{
    /**
     * @param int $id
     * @return array
     */
    public function getVars(int $id): array;
}
