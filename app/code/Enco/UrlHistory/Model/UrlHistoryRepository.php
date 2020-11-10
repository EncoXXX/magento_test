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
use Magento\Framework\Api\SearchResultsInterfaceFactory;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class UrlHistoryRepository
 * @package Enco\UrlHistory\Model
 */
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
     * @var SearchResultsInterfaceFactory $searchResultFactory
     */
    protected $searchResultFactory;

    /**
     * UrlHistoryRepository constructor.
     * @param ResourceUrlHistory $resourceModel
     * @param UrlHistoryFactory $modelFactory
     * @param CollectionFactory $collectionFactory
     * @param CollectionProcessorInterface $processor
     * @param SearchResultsInterfaceFactory $searchResultFactory
     */
    public function __construct(
        ResourceUrlHistory $resourceModel,
        UrlHistoryFactory $modelFactory,
        CollectionFactory $collectionFactory,
        CollectionProcessorInterface $processor,
        SearchResultsInterfaceFactory $searchResultFactory
    ) {
        $this->resourceModel = $resourceModel;
        $this->modelFactory = $modelFactory;
        $this->collectionFactory = $collectionFactory;
        $this->processor = $processor;
        $this->searchResultFactory = $searchResultFactory;
    }

    /**
     * Get model by ID
     * @param int $id
     * @return UrlHistory
     * @throws NoSuchEntityException
     */
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

    /**
     * Get model by URL
     * @param string $url
     * @return UrlHistory
     * @throws NoSuchEntityException
     */
    public function getByUrl(string $url)
    {
        $model = $this->modelFactory->create();
        $this->resourceModel->load($model, $url, UrlHistoryInterface::VISITED_URL);

        if (!$model->getId()) {
            throw new NoSuchEntityException(__("No such entity with url %1"));
        }
        return $model;
    }

    /**
     * Get SearchResult by searchCriteria
     * @param SearchCriteriaInterface $searchCriteria
     * @return SearchResult
     */
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

    public function getListWithCustomer(SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->collectionFactory->create();
        $collection->joinCustomerTable();

        $this->processor->process($searchCriteria, $collection);

        /** @var SearchResult $searchResult */
        $searchResult = $this->searchResultFactory->create();
        $searchResult->setSearchCriteria($searchCriteria);
        $searchResult->setItems($collection->getItems());
        $searchResult->setTotalCount($collection->getSize());

        return $searchResult;
    }
    /**
     * Delete entity from DB by ID
     * @param int $id
     */
    public function deleteById(int $id)
    {
        try {
            $model = $this->getById($id);
            $this->delete($model);
        } catch (NoSuchEntityException $e) {
        }
    }

    /**
     * Delete entity from DB by model
     * @param UrlHistoryInterface $model
     */
    public function delete(Data\UrlHistoryInterface $model)
    {
        try {
            $this->resourceModel->delete($model);
        } catch (Exception $e) {
        }
    }

    /**
     * Save model into DB
     * @param UrlHistoryInterface $model
     * @return UrlHistoryInterface|null
     */
    public function save(Data\UrlHistoryInterface $model)
    {
        try {
            $this->resourceModel->save($model);
        } catch (Exception $e) {
            return null;
        }
        return $model;
    }

    /**
     * @param string|null $name
     * @return mixed
     * @throws NoSuchEntityException
     */
    public function getByName(?string $name)
    {
        $model = $this->modelFactory->create();
        $this->resourceModel->load($model, $name, UrlHistoryInterface::CUSTOMER_NAME);

        if (!$model->getId()) {
            throw new NoSuchEntityException(__("No such entity with name %1", $name));
        }
        return $model;
    }
}
