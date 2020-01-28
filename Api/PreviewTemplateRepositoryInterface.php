<?php


namespace Overdose\PreviewEmail\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Overdose\PreviewEmail\Api\Data\PreviewTemplateInterface;

interface PreviewTemplateRepositoryInterface
{
    /**
     * @param int $id
     * @return PreviewTemplateInterface
     */
    public function getById(int $id);

    /**
     * @param PreviewTemplateInterface $model
     * @return PreviewTemplateInterface
     */
    public function save(PreviewTemplateInterface $model);

    /**
     * @param PreviewTemplateInterface $model
     * @return mixed
     */
    public function delete(PreviewTemplateInterface $model);

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return mixed
     */
    public function getList(SearchCriteriaInterface $searchCriteria);
}