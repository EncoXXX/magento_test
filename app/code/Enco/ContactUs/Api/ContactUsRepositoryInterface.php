<?php
/**
 * Repository interface of ContactUs
 * @category Smile
 * @package Enco\ContactUs
 * @authod Andriy Bednarskiy <bednarsasha@gmail.com>
 * @copyright 2020 Smile
 */

namespace Enco\ContactUs\Api;

use Enco\ContactUs\Api\Data\ContactUsInterface;
use Enco\ContactUs\Model\ContactUs;
use Magento\Framework\Api\SearchCriteriaInterface;

/**
 * Interface ContactUsRepositoryInterface
 * @package Enco\ContactUs\Api
 */
interface ContactUsRepositoryInterface
{
    /**
     * Get model by request id
     * @param int $id
     * @return mixed
     */
    public function getById(int $id);

    /**
     * Get request collection by customer id
     * @param int $id
     * @return mixed
     */
    public function getByCustomerId(int $id);

    /**
     * Get request collection by customer email
     * @param string $email
     * @return mixed
     */
    public function getByEmail(string $email);

    /**
     * Get request collection by status
     * @param int $status
     * @return mixed
     */
    public function getByStatus(int $status);

    /**
     * Get replied messages collection by request message id
     * @param int $message_id
     * @return mixed
     */
    public function getRepliedMessageById(int $message_id);

    /**
     * Returns collection by search criteria
     * @param SearchCriteriaInterface $searchCriteria
     * @return mixed
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * Save model
     * @param ContactUsInterface $model
     * @return mixed
     */
    public function save(ContactUsInterface $model);

    /**
     * Delete model
     * @param ContactUsInterface $model
     * @return mixed
     */
    public function delete(ContactUsInterface $model);
}
