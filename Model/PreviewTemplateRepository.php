<?php
declare(strict_types=1);

namespace Overdose\PreviewEmail\Model;

use Overdose\PreviewEmail\Api\Data\PreviewTemplateInterface;
use Overdose\PreviewEmail\Api\PreviewTemplateRepositoryInterface;
use Overdose\PreviewEmail\Model\ResourceModel\PreviewTemplate as PreviewTemplateResource;
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
    public $previewTemplateResource;
    /**
     * @var CollectionFactory
     */
    public $collectionFactory;

    /**
     * PreviewTemplateRepository constructor.
     * @param PreviewTemplateFactory $previewTemplateFactory
     * @param PreviewTemplateResource $previewTemplateResource
     * @param CollectionFactory $collectionFactory
     */
    public function __construct
    (
        PreviewTemplateFactory $previewTemplateFactory,
        PreviewTemplateResource $previewTemplateResource,
        CollectionFactory $collectionFactory
    ) {
        $this->modelFactory = $previewTemplateFactory;
        $this->previewTemplateResource = $previewTemplateResource;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * @param int $id
     * @return PreviewTemplateInterface
     */
    public function getById(int $id)
    {
        $model = $this->modelFactory->create();
        $this->previewTemplateResource->load($model, $id, PreviewTemplateInterface::ID);
        return $model;
    }

    /**
     * @param PreviewTemplateInterface $model
     * @return PreviewTemplateInterface
     */
    public function save(PreviewTemplateInterface $model)
    {
        try {
            $this->previewTemplateResource->save($model);
            return $model;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @param PreviewTemplateInterface $model
     * @return bool|mixed
     * @throws \Exception
     */
    public function delete(PreviewTemplateInterface $model)
    {
        try {
            $this->previewTemplateResource->delete($model);
            return true;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @inheritDoc
     * @return SearchResultInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria)
    {
        $searchResult = $this->searchResultsFactory->create();
        $collection = $this->collectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);
        $searchResult->setItems($collection->getItems());
        $searchResult->setTotalCount($collection->getSize());

        return $searchResult;
    }
}
