<?php


namespace Overdose\PreviewEmail\Api\Data;

interface PreviewTemplateInterface
{
    /** Table Name */
    const TABLE_NAME = 'preview_template';
    /** Table Fields */
    const ID = 'id';
    const TYPE = 'type';
    const FIELDS = 'fields';
    const NAME = 'name';
    const CONFIG_PATH = 'config_path';

    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $name
     * @return PreviewTemplateInterface
     */
    public function setName(string $name);

    /**
     * @param string $type
     * @return PreviewTemplateInterface
     */
    public function setType(string $type);

    /**
     * @return string
     */
    public function getType();

    /**
     * @return string
     */
    public function getFields();

    /**
     * @param string $fields
     * @return PreviewTemplateInterface
     */
    public function setFields(string $fields);

    /**
     * @param string $configPath
     * @return PreviewTemplateInterface
     */
    public function setConfigPath(string $configPath);

    /**
     * @return string
     */
    public function getConfigPath();

}