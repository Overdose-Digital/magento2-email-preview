<?php declare(strict_types=1);

namespace Overdose\PreviewEmail\Model;

use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SortOrder;
use Overdose\PreviewEmail\Api\Data\PreviewTemplateInterface;
use Overdose\PreviewEmail\Api\PreviewTemplateRepositoryInterface;
use Overdose\PreviewEmail\Model\ResourceModel\PreviewTemplate as PreviewTemplateResource;
use Overdose\PreviewEmail\Model\ResourceModel\PreviewTemplate\CollectionFactory;
use Overdose\PreviewEmail\Model\ResourceModel\PreviewTemplate\Collection;
use Overdose\PreviewEmail\Api\Data\PreviewTemplateSearchResultInterfaceFactory;

/**
 * Class PreviewTemplateRepository
 * @package Overdose\PreviewEmail\Model
 */
class PreviewTemplateRepository implements PreviewTemplateRepositoryInterface
{
    /**
     * @var PreviewTemplateFactory
     */
    public $modelFactory;
    /**
     * @var Resource
     */
    public $previewTemplateResource;
    /**
     * @var CollectionFactory
     */
    public $collectionFactory;

    /** @var PreviewTemplateSearchResultInterfaceFactory */
    private $searchResultsFactory;

    /**
     * PreviewTemplateRepository constructor.
     * @param PreviewTemplateFactory $previewTemplateFactory
     * @param PreviewTemplateResource $previewTemplateResource
     * @param CollectionFactory $collectionFactory
     * @param PreviewTemplateSearchResultInterfaceFactory $searchResultsFactory
     */
    public function __construct
    (
        PreviewTemplateFactory $previewTemplateFactory,
        PreviewTemplateResource $previewTemplateResource,
        CollectionFactory $collectionFactory,
        PreviewTemplateSearchResultInterfaceFactory $searchResultsFactory
    ) {
        $this->modelFactory = $previewTemplateFactory;
        $this->previewTemplateResource = $previewTemplateResource;
        $this->collectionFactory = $collectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
    }

    /**
     * @param int $id
     * @return PreviewTemplateInterface
     */
    public function getById(int $id): PreviewTemplateInterface
    {
        $model = $this->modelFactory->create();
        $this->previewTemplateResource->load($model, $id, PreviewTemplateInterface::ID);
        return $model;
    }

    /**
     * @param PreviewTemplateInterface $model
     * @return PreviewTemplateInterface
     * @throws CouldNotSaveException
     */
    public function save(PreviewTemplateInterface $model): PreviewTemplateInterface
    {
        try {
            $this->previewTemplateResource->save($model);
            return $model;
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        }
    }

    /**
     * @param PreviewTemplateInterface $model
     * @return mixed
     * @throws NoSuchEntityException
     */
    public function delete(PreviewTemplateInterface $model)
    {
        try {
            $this->previewTemplateResource->delete($model);
            return true;
        } catch (\Exception $e) {
            throw new NoSuchEntityException(__($e->getMessage()));
        }
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return mixed
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->collectionFactory->create();
        $this->addFiltersToCollection($searchCriteria, $collection);
        $this->addSortOrdersToCollection($searchCriteria, $collection);
        $this->addPagingToCollection($searchCriteria, $collection);

        $collection->load();

        return $this->buildSearchResult($searchCriteria, $collection);
    }

    private function addFiltersToCollection(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        foreach ($searchCriteria->getFilterGroups() as $filterGroup) {
            $fields = $conditions = [];
            foreach ($filterGroup->getFilters() as $filter) {
                $fields[] = $filter->getField();
                $conditions[] = [$filter->getConditionType() => $filter->getValue()];
            }
            $collection->addFieldToFilter($fields, $conditions);
        }
    }

    private function addSortOrdersToCollection(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        foreach ((array)$searchCriteria->getSortOrders() as $sortOrder) {
            $direction = $sortOrder->getDirection() == SortOrder::SORT_ASC ? 'asc' : 'desc';
            $collection->addOrder($sortOrder->getField(), $direction);
        }
    }

    private function addPagingToCollection(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        $collection->setPageSize($searchCriteria->getPageSize());
        $collection->setCurPage($searchCriteria->getCurrentPage());
    }

    private function buildSearchResult(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        $searchResults = $this->searchResultsFactory->create();

        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }
}
