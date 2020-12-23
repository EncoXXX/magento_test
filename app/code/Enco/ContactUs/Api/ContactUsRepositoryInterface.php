<?php
/**
 * Repository interface of ContactUs
 *
 * @category Smile Smile
 * @package Enco\ContactUs
 * @authod Andriy Bednarskiy <bednarsasha@gmail.com>
 * @copyright 2020 Enco
 */

namespace Enco\ContactUs\Api;

use Enco\ContactUs\Api\Data\ContactUsInterface;
use Enco\ContactUs\Model\ContactUs;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\DataObject;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Interface ContactUsRepositoryInterface
 */
interface ContactUsRepositoryInterface
{
    /**
     * Get model by request id
     *
     * @param int $id
     *
     * @return ContactUsInterface
     */
    public function getById(int $id);

    /**
     * Get request collection by customer id
     *
     * @param int $id
     *
     * @return SearchResultsInterface
     */
    public function getByCustomerId(int $id);

    /**
     * Get request collection by customer email
     *
     * @param string $email
     *
     * @return SearchResultsInterface
     */
    public function getByEmail(string $email);

    /**
     * Get request collection by status
     *
     * @param int $status
     *
     * @return SearchResultsInterface
     */
    public function getByStatus(int $status);

    /**
     * Get replied messages collection by request message id
     *
     * @param int $messageId
     *
     * @return ContactUsInterface
     */
    public function getRepliedMessageById(int $messageId);

    /**
     * Returns collection by search criteria
     *
     * @param SearchCriteriaInterface $searchCriteria
     *
     * @return mixed
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * Save model
     *
     * @param ContactUsInterface $model
     *
     * @return ContactUsInterface
     */
    public function save(ContactUsInterface $model);

    /**
     * Delete model
     *
     * @param ContactUsInterface $model
     *
     * @return void
     */
    public function delete(ContactUsInterface $model);

    /**
     * Returns all replied messages with main message
     *
     * @param int $messageId
     *
     * @return ContactUs[]
     * @throws NoSuchEntityException
     */
    public function getWithReplied(int $messageId);
}
