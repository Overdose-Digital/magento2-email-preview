<?php declare(strict_types=1);

namespace Overdose\PreviewEmail\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Overdose\PreviewEmail\Api\Data\PreviewTemplateInterface;

/**
 * Interface PreviewTemplateRepositoryInterface
 * @package Overdose\PreviewEmail\Api
 */
interface PreviewTemplateRepositoryInterface
{
    /**
     * @param int $id
     * @return PreviewTemplateInterface
     */
    public function getById(int $id): PreviewTemplateInterface;

    /**
     * @param PreviewTemplateInterface $model
     * @return PreviewTemplateInterface
     * @throws CouldNotSaveException
     */
    public function save(PreviewTemplateInterface $model): PreviewTemplateInterface;

    /**
     * @param PreviewTemplateInterface $model
     * @return mixed
     * @throws NoSuchEntityException
     */
    public function delete(PreviewTemplateInterface $model);

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return mixed
     */
    public function getList(SearchCriteriaInterface $searchCriteria);
}
