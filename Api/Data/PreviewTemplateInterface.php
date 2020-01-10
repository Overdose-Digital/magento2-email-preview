<?php
declare(strict_types=1);

namespace Overdose\PreviewEmail\Api\Data;

interface PreviewTemplateInterface
{
    const TABLE_NAME = 'preview_email_template';

    const ID = 'id';

    const TEMPLATE_ID = 'template_id';

    const TEMPLATE_NAME = 'template_name';

    const TEMPLATE_TYPE = 'template_type';

    /**
     * @param string $name
     * @return $this
     */
    public function setTemplateName(string $name);

    /**
     * @return string
     */
    public function getTemplateName();

    /**
     * @param integer $templateId
     * @return $this
     */
    public function setTemplateId(int $templateId);

    /**
     * @return integer
     */
    public function getTemplateId();


}
