<?php
/**
 * ContactUs repository
 * @category Smile
 * @package Enco\ContactUs
 * @author Andriy Benarskiy <bednarsasha@gmail.com>
 * @copyright 2020 Smile
 */

namespace Enco\ContactUs\Model;

use Enco\ContactUs\Api\ContactUsRepositoryInterface;
use Enco\ContactUs\Api\Data\ContactUsInterface;
use Enco\ContactUs\Api\Data\ContactUsInterfaceFactory;
use Enco\ContactUs\Model\ResourceModel\ContactUs as ResourceModel;
use Enco\ContactUs\Model\ResourceModel\ContactUs\CollectionFactory;
use Exception;
use Magento\Framework\Api\SearchCriteria;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Api\SearchResultsInterfaceFactory;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Message\ManagerInterface;

class ContactUsRepository implements ContactUsRepositoryInterface
{

    /**
     * @var ManagerInterface
     */
    protected $messageManager;

    /**
     * @var ContactUsInterfaceFactory $modelFactory
     */
    protected $modelFactory;

    /**
     * @var ResourceModel $resourceModel
     */
    protected $resourceModel;

    /**
     * @var ResourceModel\ContactUs\CollectionFactory $collectionFactory
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
     * @var SearchCriteriaBuilder
     */
    protected $criteriaBuilder;

    /**
     * Uses for getWithReplied to return correct message id
     *
     * @var int|null $messageId
     */
    protected $messageId = null;

    public function __construct(
        ResourceModel $resourceModel,
        CollectionFactory $collectionFactory,
        ContactUsInterfaceFactory $modelFactory,
        CollectionProcessorInterface $processor,
        SearchResultsInterfaceFactory $searchResultFactory,
        SearchCriteriaBuilder $criteriaBuilder,
        ManagerInterface $messageManager
    ) {
        $this->resourceModel = $resourceModel;
        $this->collectionFactory = $collectionFactory;
        $this->modelFactory = $modelFactory;
        $this->processor = $processor;
        $this->searchResultFactory = $searchResultFactory;
        $this->criteriaBuilder = $criteriaBuilder;
        $this->messageManager = $messageManager;
    }

    /**
     * Get model by request id
     * @param int $id
     *
     * @return ContactUsInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $id)
    {
        /**
         * @var ContactUsInterface
         */
        $model = $this->modelFactory->create();
        $this->resourceModel->load($model, $id, ContactUsInterface::ID);

        if ($model->getId() == false) {
            throw new NoSuchEntityException(__('No such entity with %1', $id));
        }
        return $model;
    }

    /**
     * Get request collection by customer id
     * @param int $id
     *
     * @return SearchResultsInterface
     * @throws NoSuchEntityException
     */
    public function getByCustomerId(int $id)
    {
        /**
         * @var SearchCriteria $searchCriteria
         */
        $searchCriteria = $this->criteriaBuilder
            ->addFilter(
                ContactUsInterface::CUSTOMER_ID,
                $id,
                'eq'
            )
            ->create();
        return $this->getList($searchCriteria);
    }

    /**
     * Get request collection by customer email
     * @param string $email
     *
     * @return SearchResultsInterface
     * @throws NoSuchEntityException
     */
    public function getByEmail(string $email)
    {
        /**
         * @var SearchCriteria $searchCriteria
         */
        $searchCriteria = $this->criteriaBuilder
            ->addFilter(
                ContactUsInterface::EMAIL,
                $email,
                'eq'
            )
            ->create();
        return $this->getList($searchCriteria);
    }

    /**
     * Get request collection by status
     * @param int $status
     *
     * @return SearchResultsInterface
     * @throws NoSuchEntityException
     */
    public function getByStatus(int $status)
    {
        /**
         * @var SearchCriteria $searchCriteria
         */
        $searchCriteria = $this->criteriaBuilder
            ->addFilter(
                ContactUsInterface::STATUS,
                $status,
                'eq'
            )
            ->create();
        return $this->getList($searchCriteria);
    }

    /**
     * Get replied messages collection by request message id
     * @param int $message_id
     *
     * @return ContactUsInterface
     * @throws NoSuchEntityException
     */
    public function getRepliedMessageById(int $message_id)
    {
        /**
         * @var ContactUsInterface
         */
        $model = $this->modelFactory->create();
        $this->resourceModel->load($model, $message_id, ContactUsInterface::REPLY_ID);

        if ($model->getId() == false) {
            throw new NoSuchEntityException(__('No such entity with replied message id %1', $message_id));
        }
        return $model;
    }

    /**
     * Save model
     * @param ContactUsInterface $model
     *
     * @return ContactUsInterface
     * @throws AlreadyExistsException
     */
    public function save(ContactUsInterface $model)
    {
        if ($model->isAdmin()) {
            if ($model->getReplyId() !== null && is_int($model->getReplyId())) {
                $oldMessageModel = $this->modelFactory->create();
                $oldMessageModel->setId($model->getReplyId());
                $oldMessageModel->setStatus(ContactUsInterface::REPLIED_STATUS);
                $this->resourceModel->save($oldMessageModel);
            }
            $model
                ->setStatus(ContactUsInterface::REPLIED_STATUS)
                ->setCustomerName("Admin")
                ->setEmail("admin@smile-m2.lxc")
                ->setPhone("+380991111111");
        }
        $this->resourceModel->save($model);
        return $model;
    }

    /**
     * Delete model
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
     * @param SearchCriteriaInterface $searchCriteria
     *
     * @return SearchResultsInterface
     * @throws NoSuchEntityException
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        /**
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
     * @param int $messageId
     *
     * @return ContactUs[]
     * @throws NoSuchEntityException
     */
    public function getWithReplied(int $messageId)
    {
        /**
         * @var ResourceModel\Collection $collection
         */
        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter(
            [ContactUsInterface::ID, ContactUsInterface::REPLY_ID],
            [$messageId, $messageId]
        );

        /**
         * @var ContactUs[] $model
         */
        $model = $collection->getItems();

        if ($model[$messageId]->getReplyId() !== null) {
            $messageId = $model[$messageId]->getReplyId();
            $collection = $this->collectionFactory->create();
            $collection->addFieldToFilter(
                [ContactUsInterface::ID, ContactUsInterface::REPLY_ID],
                [$messageId, $messageId]
            );
            $model = $collection->getItems();
        }

        if (count($model)<1) {
            throw new NoSuchEntityException(__("No items("));
        }

        $this->messageId = $messageId;
        return $model;
    }

    /**
     * Returns correct message ID for Replied messages
     *
     * @return int
     */
    public function getMessageId(){
        return $this->messageId;
    }
}
