<?php
/**
 * Model interface of ContactUs
 * @category Smile
 * @package Enco\ContactUs
 * @author Andriy Bednarskiy
 * @copyright 2020 Smile
 */

namespace Enco\ContactUs\Api\Data;

/**
 * Model interface ContactUsInterface
 * @package Enco\ContactUs\Api\Data
 */
interface ContactUsInterface
{
    /**#@+
     * Table name
     */
    const TABLE_NAME = 'contact_us';
    /**#@-**/

    /**#@+
     * Fields
     */
    const ID = 'id';
    const CUSTOMER_ID = 'customer_id';
    const NAME = 'name';
    const THEME = 'theme';
    const MESSAGE = 'message';
    const EMAIL = 'email';
    const REPLY_ID = 'reply_id';
    const STATUS = 'status';
    const CREATED_AT = 'created_at';
    const PHONE = 'phone';
    const IS_ADMIN = 'is_admin';
    /**#@-*/

    /**#@+
     * Statuses
     * @note
     */
    const NEW_MESSAGE_STATUS = 0;
    const IGNORED_STATUS = 1;
    const REPLIED_STATUS = 2;

    /**#@-*/

    /**
     * Returns customer id if exist
     * @return int|null
     */
    public function getCustomerId():?int;

    /**
     * returns customer name from form
     * @return string
     */
    public function getCustomerName():string;

    /**
     * Returns theme of request
     * @return string
     */
    public function getTheme():string;

    /**
     * Returns message of request
     * @return string
     */
    public function getMessage():string;

    /**
     * returns customer email from form
     * @return string
     */
    public function getEmail():string;

    /**
     * Returns id of replied message
     * @return int|null
     */
    public function getReplyId():?int;

    /**
     * Returns status of request (use this interface statuses)
     * @return int
     */
    public function getStatus():int;

    /**
     * Returns when was created request
     * @return string
     */
    public function getCreatedAt():string;

    /**
     * Returns true if message was written by admin
     * @return bool
     */
    public function isAdmin():bool;

    /**
     * Returns customer phone
     * @return string
     */
    public function getPhone():?string;

    /**
     * Set Customer id (not required)
     * @param int $id
     * @return $this
     */
    public function setCustomerId(int $id) : self;

    /**
     * Set Customer name
     * @param string $name
     * @return $this
     */
    public function setCustomerName(string $name): self;

    /**
     * Set theme of request
     * @param string $theme
     * @return $this
     */
    public function setTheme(string $theme) : self;

    /**
     * Set message of request
     * @param string $message
     * @return $this
     */
    public function setMessage(string $message) : self;

    /**
     * Set customer email (not required if admin)
     * @param string|null $email
     * @return $this
     */
    public function setEmail(?string $email) : self;

    /**
     * Set reply message id(not required if message is not reply)
     * @param int $replyId
     * @return $this
     */
    public function setReplyId(int $replyId) : self;

    /**
     * Set status of request (by default - self::NEW_MESSAGE_STATUS)
     * @param int $status
     * @return $this
     */
    public function setStatus(int $status) : self;

    /**
     * Set admin reply or request(not required, by default: false)
     * @param bool $isAdmin
     * @return $this
     */
    public function setIsAdmin(bool $isAdmin) : self;

    /**
     * Set customer phone (not required)
     * @param string $phone
     * @return $this
     */
    public function setPhone(string $phone) : self;
}
