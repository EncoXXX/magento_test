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
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterfaceFactory;
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
     * @var \Enco\ContactUs\Model\ResourceModel\ContactUs $resourceModel
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
     * @return mixed|void
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
     * @return mixed
     */
    public function getByCustomerId(int $id)
    {
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
     * @return mixed|void
     */
    public function getByEmail(string $email)
    {
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
     * @return mixed|void
     */
    public function getByStatus(int $status)
    {
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
     * @return mixed|void
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
     * @return mixed|void
     */
    public function save(ContactUsInterface $model)
    {
        try {
            $this->resourceModel->save($model);
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            return null;
        }
        return $model;
    }

    /**
     * Delete model
     * @param ContactUsInterface $model
     * @return mixed|void
     */
    public function delete(ContactUsInterface $model)
    {
        try {
            $this->resourceModel->delete($model);
        } catch (\Exception $e) {
        }
    }

    /**
     * Returns collection by search criteria
     * @param SearchCriteriaInterface $searchCriteria
     * @return mixed
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->collectionFactory->create();
        $this->processor->process($searchCriteria, $collection);

        $searchResult = $this->searchResultFactory->create();
        $searchResult->setSearchCriteria($searchCriteria);
        $searchResult->setItems($collection->getItems());
        $searchResult->setTotalCount($collection->getSize());

        return $searchResult;
    }
}
