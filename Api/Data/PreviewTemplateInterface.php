<?php declare(strict_types=1);

namespace Overdose\PreviewEmail\Api\Data;

/**
 * Interface PreviewTemplateInterface
 * @package Overdose\PreviewEmail\Api\Data
 */
interface PreviewTemplateInterface
{
    /** Table Name */
    const TABLE_NAME = 'preview_template';
    /** Table Fields */
    const ID = 'id';
    const TYPE = 'type';
    const NAME = 'name';

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @param string $name
     * @return PreviewTemplateInterface
     */
    public function setName(string $name): PreviewTemplateInterface;

    /**
     * @param string $type
     * @return PreviewTemplateInterface
     */
    public function setType(string $type): PreviewTemplateInterface;

    /**
     * @return string
     */
    public function getType(): string;
}
