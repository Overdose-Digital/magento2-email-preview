<?php
declare(strict_types=1);

namespace Overdose\PreviewEmail\Model;

use Magento\Framework\Model\AbstractModel;
use Overdose\PreviewEmail\Api\Data\PreviewTemplateInterface;
use Overdose\PreviewEmail\Model\ResourceModel\PreviewTemplate as Resource;

class PreviewTemplate extends AbstractModel implements PreviewTemplateInterface
{
    const CACHE_TAG = 'preview_email_template';

    /**
     * @param string $name
     * @return $this
     */
    public function setTemplateName(string $name)
    {
        $this->setData(self::TEMPLATE_NAME, $name);
        return $this;
    }

    /**
     * @return string
     */
    public function getTemplateName()
    {
        return $this->getData(self::TEMPLATE_NAME);
    }

    /**
     * @param int $templateId
     * @return $this
     */
    public function setTemplateId(int $templateId)
    {
        $this->setData(self::TEMPLATE_ID, $templateId);
        return $this;
    }

    /**
     * @return integer
     */
    public function getTemplateId()
    {
        return $this->getData(self::TEMPLATE_ID);
    }

    protected function _construct()
    {
        $this->_init(Resource::class);
    }
}