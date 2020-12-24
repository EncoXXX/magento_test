<?php
/**
 * ContactUs repository
 *
 * @category Smile
 * @package Enco\ContactUs
 * @author Andriy Benarskiy <bednarsasha@gmail.com>
 * @copyright 2020 Enco
 */

namespace Enco\ContactUs\Model;

use Enco\ContactUs\Api\ContactUsRepositoryInterface;
use Enco\ContactUs\Api\Data\ContactUsInterface;
use Enco\ContactUs\Api\Data\ContactUsInterfaceFactory;
use Enco\ContactUs\Model\ResourceModel\ContactUs as ResourceModel;
use Enco\ContactUs\Model\ResourceModel\ContactUs\CollectionFactory;
use Exception;
use Magento\Backend\Model\Auth\Session;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Api\SearchResultsInterfaceFactory;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Exception\NoSuchEntityException;

class ContactUsRepository implements ContactUsRepositoryInterface
{

    /**
     * Factory for ContactUs model
     *
     * @var ContactUsInterfaceFactory $modelFactory
     */
    protected $modelFactory;

    /**
     * ContactUs resource model
     *
     * @var ResourceModel $resourceModel
     */
    protected $resourceModel;

    /**
     * ContactUs collection factory
     *
     * @var ResourceModel\ContactUs\CollectionFactory $collectionFactory
     */
    protected $collectionFactory;

    /**
     * Collection processor
     *
     * @var CollectionProcessorInterface $processor
     */
    protected $processor;

    /**
     * Search result factory
     *
     * @var SearchResultsInterfaceFactory $searchResultFactory
     */
    protected $searchResultFactory;

    /**
     * Search criteria builder
     *
     * @var SearchCriteriaBuilder
     */
    protected $criteriaBuilder;

    /**
     * Uses for getWithReplied to return correct message id
     *
     * @var int|null $messageId
     */
    protected $messageId = null;

    /**
     * Admin session
     *
     * @var Session
     */
    protected $adminSession;

    /**
     * ContactUsRepository constructor.
     *
     * @param ResourceModel $resourceModel
     * @param CollectionFactory $collectionFactory
     * @param ContactUsInterfaceFactory $modelFactory
     * @param CollectionProcessorInterface $processor
     * @param SearchResultsInterfaceFactory $searchResultFactory
     * @param SearchCriteriaBuilder $criteriaBuilder
     * @param Session $adminSession
     */
    public function __construct(
        ResourceModel $resourceModel,
        CollectionFactory $collectionFactory,
        ContactUsInterfaceFactory $modelFactory,
        CollectionProcessorInterface $processor,
        SearchResultsInterfaceFactory $searchResultFactory,
        SearchCriteriaBuilder $criteriaBuilder,
        Session $adminSession
    ) {
        $this->resourceModel = $resourceModel;
        $this->collectionFactory = $collectionFactory;
        $this->modelFactory = $modelFactory;
        $this->processor = $processor;
        $this->searchResultFactory = $searchResultFactory;
        $this->criteriaBuilder = $criteriaBuilder;
        $this->adminSession = $adminSession;
    }

    /**
     * Get model by request id
     *
     * @param int $id
     *
     * @return ContactUsInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $id)
    {
        /**
         * ContactUs model
         *
         * @var ContactUsInterface
         */
        $model = $this->modelFactory->create();
        $this->resourceModel->load($model, $id, ContactUsInterface::ID);

        if (!$model->getId()) {
            throw new NoSuchEntityException(__('No such entity with %1', $id));
        }

        return $model;
    }

    /**
     * Get request collection by customer id
     *
     * @param int $id
     *
     * @return SearchResultsInterface
     * @throws NoSuchEntityException
     */
    public function getByCustomerId(int $id)
    {
        return $this->getList($searchCriteria = $this->criteriaBuilder
            ->addFilter(
                ContactUsInterface::CUSTOMER_ID,
                $id,
                'eq'
            )
            ->create());
    }

    /**
     * Get request collection by customer email
     *
     * @param string $email
     *
     * @return SearchResultsInterface
     * @throws NoSuchEntityException
     */
    public function getByEmail(string $email)
    {
        return $this->getList(
            $this->criteriaBuilder
                ->addFilter(
                    ContactUsInterface::EMAIL,
                    $email,
                    'eq'
                )
                ->create()
        );
    }

    /**
     * Get request collection by status
     *
     * @param int $status
     *
     * @return SearchResultsInterface
     * @throws NoSuchEntityException
     */
    public function getByStatus(int $status)
    {
        return $this->getList(
            $this->criteriaBuilder
            ->addFilter(
                ContactUsInterface::STATUS,
                $status,
                'eq'
            )
            ->create()
        );
    }

    /**
     * Get replied messages collection by request message id
     *
     * @param int $messageId
     *
     * @return ContactUsInterface
     * @throws NoSuchEntityException
     */
    public function getRepliedMessageById(int $messageId)
    {
        /**
         * @var ContactUsInterface
         */
        $model = $this->modelFactory->create();
        $this->resourceModel->load($model, $messageId, ContactUsInterface::REPLY_ID);

        if (!$model->getId()) {
            throw new NoSuchEntityException(__('No such entity with replied message id %1', $messageId));
        }

        return $model;
    }

    /**
     * Save model
     *
     * @param ContactUsInterface $model
     *
     * @return ContactUsInterface
     * @throws AlreadyExistsException
     */
    public function save(ContactUsInterface $model)
    {
        if ($model->isAdmin()) {
            if ($model->getReplyId() !== null) {
                $oldMessageModel = $this->modelFactory->create();
                $oldMessageModel->setId($model->getReplyId());
                $oldMessageModel->setStatus(ContactUsInterface::REPLIED_STATUS);
                $oldMessageModel->setIsAdminEdit(true);
                $this->resourceModel->save($oldMessageModel);
            }
            if(!$model->getData(ContactUsInterface::NAME)){
                $model->setCustomerName($this->adminSession->getUser()->getName());
            }
            if(!$model->getData(ContactUsInterface::EMAIL)){
                $model->setEmail($this->adminSession->getUser()->getEmail());
            }

            $model->setStatus(ContactUsInterface::REPLIED_STATUS);
        }
        $this->resourceModel->save($model);

        return $model;
    }

    /**
     * Delete model
     *
     * @param ContactUsInterface $model
     *
     * @return void
     * @throws Exception
     */
    public function delete(ContactUsInterface $model)
    {
        $this->resourceModel->delete($model);
    }

    /**
     * Returns collection by search criteria
     *
     * @param SearchCriteriaInterface $searchCriteria
     *
     * @return SearchResultsInterface
     * @throws NoSuchEntityException
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        /**
         * ContactUs collection
         *
         * @var ResourceModel\Collection $collection
         */
        $collection = $this->collectionFactory->create();
        $this->processor->process($searchCriteria, $collection);

        $searchResult = $this->searchResultFactory->create();
        $searchResult->setSearchCriteria($searchCriteria);
        $searchResult->setItems($collection->getItems());
        $searchResult->setTotalCount($collection->getSize());
        if ($collection->getSize() == 0) {
            throw new NoSuchEntityException(__("No entity with this params"));
        }

        return $searchResult;
    }

    /**
     * Returns all replied messages with main message
     *
     * @param int $messageId
     *
     * @return SearchResultsInterface
     * @throws NoSuchEntityException
     */
    public function getWithReplied(int $messageId)
    {
        /**
         * ContactUs collection
         *
         * @var ResourceModel\Collection $collection
         */
        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter(
            [ContactUsInterface::ID, ContactUsInterface::REPLY_ID],
            [$messageId, $messageId]
        );

        /**
         * Array with ContactUs model
         *
         * @var ContactUs[] $models
         */
        $models = $collection->getItems();

        if (!count($models)) {
            throw new NoSuchEntityException(__("No items("));
        }

        if ($models[$messageId]->getReplyId() !== null) {
            $messageId = $models[$messageId]->getReplyId();
            $collection = $this->collectionFactory->create();
            $collection->addFieldToFilter(
                [ContactUsInterface::ID, ContactUsInterface::REPLY_ID],
                [$messageId, $messageId]
            );
            $models = $collection->getItems();
        }
        if (!count($models)) {
            throw new NoSuchEntityException(__("No items("));
        }

        $searchResult = $this->searchResultFactory->create();

        $searchResult->setItems($models);
        $searchResult->setTotalCount($collection->getSize());

        $this->messageId = $messageId;

        return $searchResult;
    }

    /**
     * Returns correct message ID for Replied messages
     *
     * @return int
     */
    public function getMessageId()
    {
        return $this->messageId;
    }
}
