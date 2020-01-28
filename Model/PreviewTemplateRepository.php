<?php
declare(strict_types=1);

namespace Overdose\PreviewEmail\Model;

use Magento\Framework\Api\SearchCriteriaInterface;
use Overdose\PreviewEmail\Api\Data\PreviewTemplateInterface;
use Overdose\PreviewEmail\Api\PreviewTemplateRepositoryInterface;
use Overdose\PreviewEmail\Model\ResourceModel\PreviewTemplate as Resource;
use Overdose\PreviewEmail\Model\ResourceModel\PreviewTemplate\CollectionFactory;

class PreviewTemplateRepository implements PreviewTemplateRepositoryInterface
{
    /**
     * @var PreviewTemplateFactory
     */
    public $modelFactory;
    /**
     * @var Resource
     */
    public $resource;
    /**
     * @var CollectionFactory
     */
    public $collectionFactory;

    /**
     * PreviewTemplateRepository constructor.
     * @param PreviewTemplateFactory $previewTemplateFactory
     * @param Resource $resource
     * @param CollectionFactory $collectionFactory
     */
    public function __construct
    (
        PreviewTemplateFactory $previewTemplateFactory,
        Resource $resource,
        CollectionFactory $collectionFactory
    ) {
        $this->modelFactory = $previewTemplateFactory;
        $this->resource = $resource;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * @param int $id
     * @return PreviewTemplateInterface
     */
    public function getById(int $id)
    {
        $model = $this->modelFactory->create();
        $this->resource->load($model, $id, PreviewTemplateInterface::ID);
        return $model;
    }

    /**
     * @param PreviewTemplateInterface $model
     * @return PreviewTemplateInterface
     */
    public function save(PreviewTemplateInterface $model)
    {
        try {
            $this->resource->save($model);
            return $model;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @param PreviewTemplateInterfac $model
     * @return bool|mixed
     * @throws \Exception
     */
    public function delete(PreviewTemplateInterface $model)
    {
        try {
            $this->resource->delete($model);
            return true;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @inheritDoc
     * @return SearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $searchResult = $this->searchResultsFactory->create();
        $collection = $this->collectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);
        $searchResult->setItems($collection->getItems());
        $searchResult->setTotalCount($collection->getSize());

        return $searchResult;
    }
}