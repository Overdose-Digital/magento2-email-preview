<?php


namespace Overdose\PreviewEmail\Model;


use Magento\Framework\Model\AbstractModel;
use Overdose\PreviewEmail\Api\Data\PreviewTemplateInterface;
use Overdose\PreviewEmail\Model\ResourceModel\PreviewTemplate as Resource;

class PreviewTemplate extends AbstractModel implements PreviewTemplateInterface
{
    /**
     * @inheritDoc
     */
    public function getName()
    {
        return $this->getData(self::NAME);
    }

    /**
     * @inheritDoc
     */
    public function setName(string $name)
    {
        $this->setData(self::NAME, $name);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setType(string $type)
    {
        $this->setType(self::TYPE, $type);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getType()
    {
        return $this->getData(self::TYPE);
    }

    /**
     * @inheritDoc
     */
    public function getFields()
    {
        return $this->getData(self::FIELDS);
    }

    /**
     * @inheritDoc
     */
    public function setFields(string $fields)
    {
        $this->setData(self::FIELDS, $fields);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setConfigPath(string $configPath)
    {
        $this->setData(self::CONFIG_PATH, $configPath);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getConfigPath()
    {
        return $this->getData(self::CONFIG_PATH);
    }

    protected function _construct()
    {
        $this->_init(Resource::class);
    }
}