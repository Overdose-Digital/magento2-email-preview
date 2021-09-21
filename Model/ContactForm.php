<?php declare(strict_types=1);

namespace Overdose\PreviewEmail\Model;

/**
 * Class ContactForm
 * @package Overdose\PreviewEmail\Model
 */
class ContactForm implements \Overdose\PreviewEmail\Api\Data\PreviewTemplateVaribles
{
    public function __construct()
    {
    }

    /**
     * @param int $id
     * @return array
     */
    public function getVars(int $id): array
    {
        return [
        ];
    }
}
