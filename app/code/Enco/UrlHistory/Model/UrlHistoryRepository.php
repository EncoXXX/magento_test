<?php
/**
 * @category Smile
 * @package Enco\UrlHistory
 * @author Andriy Bednarskiy <bednarsasha@gmail.com>
 * @copyright 2020 Smile
 */

namespace Enco\UrlHistory\Model;

use Enco\UrlHistory\Api\Data;
use Enco\UrlHistory\Api\Data\UrlHistoryInterface;
use Enco\UrlHistory\Api\UrlHistoryRepositoryInterface;
use Enco\UrlHistory\Model\ResourceModel\UrlHistory as ResourceUrlHistory;
use Enco\UrlHistory\Model\ResourceModel\UrlHistory\CollectionFactory;
use Exception;
use Magento\Framework\Api\Search\SearchResult;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Exception\NoSuchEntityException;

class UrlHistoryRepository implements UrlHistoryRepositoryInterface
{

    /**
     * @var ResourceModel\UrlHistory $resourceModel
     */
    protected $resourceModel;

    /**
     * @var UrlHistory $modelFactory
     */
    protected $modelFactory;

    /**
     * @var CollectionFactory $collectionFactory
     */
    protected $collectionFactory;

    /**
     * @var CollectionProcessorInterface $processor
     */
    protected $processor;

    /**
     * @var SearchResultsInterface $searchResultFactory
     */
    protected $searchResultFactory;

    public function __construct(
        ResourceUrlHistory $resourceModel,
        UrlHistoryFactory $modelFactory,
        CollectionFactory $collectionFactory,
        CollectionProcessorInterface $processor,
        SearchResultsInterface $searchResultFactory
    ) {
        $this->resourceModel = $resourceModel;
        $this->modelFactory = $modelFactory;
        $this->collectionFactory = $collectionFactory;
        $this->processor = $processor;
        $this->searchResultFactory = $searchResultFactory;
    }

    public function getById(int $id)
    {
        /** @var UrlHistory $model */
        $model = $this->modelFactory->create();
        $this->resourceModel->load($model, $id, UrlHistoryInterface::ID);
        if (!$model->getId()) {
            throw new NoSuchEntityException(__('No such entity %1', $id));
        }
        return $model;
    }

    public function getByUrl(string $url)
    {
        $model = $this->modelFactory->create();
        $this->resourceModel->load($model, $url, UrlHistoryInterface::VISITED_URL);

        if (!$model->getId()) {
            throw new NoSuchEntityException(__("No such entity with url %1"));
        }
        return $model;
    }

    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->collectionFactory->create();

        $this->processor->process($searchCriteria, $collection);

        /** @var SearchResult $searchResult */
        $searchResult = $this->searchResultFactory->create();
        $searchResult->setSearchCriteria($searchCriteria);
        $searchResult->setItems($collection->getItems());
        $searchResult->setTotalCount($collection->getSize());

        return $searchResult;
    }

    public function deleteById(int $id)
    {
        try {
            $model = $this->getById($id);
            $this->delete($model);
        } catch (NoSuchEntityException $e) {
        }
    }

    public function delete(Data\UrlHistoryInterface $model)
    {
        try {
            $this->resourceModel->delete($model);
        } catch (Exception $e) {
        }
    }

    public function save(Data\UrlHistoryInterface $model)
    {
        try {
            $this->resourceModel->save($model);
        } catch (Exception $e) {
            return null;
        }
        return $model;
    }
}
