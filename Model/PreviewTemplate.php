<?php declare(strict_types=1);

namespace Overdose\PreviewEmail\Model;

use Magento\Framework\Model\AbstractModel;
use Overdose\PreviewEmail\Api\Data\PreviewTemplateInterface;

/**
 * Class PreviewTemplate
 * @package Overdose\PreviewEmail\Model
 */
class PreviewTemplate extends AbstractModel implements PreviewTemplateInterface
{
    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return $this->getData(self::NAME);
    }

    /**
     * @inheritDoc
     */
    public function setName(string $name): PreviewTemplateInterface
    {
        $this->setData(self::NAME, $name);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setType(string $type): PreviewTemplateInterface
    {
        $this->setData(self::TYPE, $type);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getType(): string
    {
        return $this->getData(self::TYPE);
    }

    /**
     * @inheritDoc
     */
    public function getFields(): string
    {
        return $this->getData(self::FIELDS);
    }

    /**
     * @inheritDoc
     */
    public function setFields(string $fields): PreviewTemplateInterface
    {
        $this->setData(self::FIELDS, $fields);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setConfigPath(string $configPath): PreviewTemplateInterface
    {
        $this->setData(self::CONFIG_PATH, $configPath);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getConfigPath(): string
    {
        return $this->getData(self::CONFIG_PATH);
    }

    protected function _construct()
    {
        $this->_init(\Overdose\PreviewEmail\Model\ResourceModel\PreviewTemplate::class);
    }
}
