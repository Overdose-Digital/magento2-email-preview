<?php

namespace Overdose\PreviewEmail\Api\Data;

interface PreviewTemplateVaribles
{
    /**
     * @param int $id
     * @return array
     */
    public function getVars(int $id): array;
}
