<?php
/**
 * ContactUs model
 *
 * @category Smile Smile
 * @package Enco\ContactUs
 * @author Andriy Bednarskiy <bednarsasha@gmail.com>
 * @copyright 2020 Enco
 */
namespace Enco\ContactUs\Model;

use Enco\ContactUs\Api\Data\ContactUsInterface;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;

class ContactUs extends AbstractModel implements ContactUsInterface
{
    /**
     * ContactUs validator
     *
     * @var ContactUsValidator $validatorBeforeSave
     */
    protected $validatorBeforeSave;

    /**
     * ContactUs constructor.
     *
     * @param Context $context
     * @param Registry $registry
     * @param ContactUsValidator $validatorBeforeSave
     * @param AbstractResource|null $resource
     * @param AbstractDb|null $resourceCollection
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        ContactUsValidator $validatorBeforeSave,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
        $this->_validatorBeforeSave = $validatorBeforeSave;
    }

    /**
     * Construct method (with one '_')
     */
    protected function _construct()
    {
        parent::_construct();
        $this->_init(ResourceModel\ContactUs::class);
        $this->setIdFieldName(static::ID);
    }

    /**
     * Returns customer id if exist
     *
     * @return int|null
     */
    public function getCustomerId(): ?int
    {
        return $this->getData(static::CUSTOMER_ID);
    }

    /**
     * returns customer name from form
     *
     * @return string
     */
    public function getCustomerName(): string
    {
        return $this->getData(static::NAME);
    }

    /**
     * Returns theme of request
     *
     * @return string
     */
    public function getTheme(): string
    {
        return $this->getData(static::THEME);
    }

    /**
     * Returns message of request
     *
     * @return string
     */
    public function getMessage(): string
    {
        return $this->getData(static::MESSAGE);
    }

    /**
     * returns customer email from form
     *
     * @return string
     */
    public function getEmail(): string
    {
        return $this->getData(static::EMAIL);
    }

    /**
     * Returns id of replied message
     *
     * @return int|null
     */
    public function getReplyId(): ?int
    {
        return $this->getData(static::REPLY_ID);
    }

    /**
     * Returns status of request (use this interface statuses)
     *
     * @return int
     */
    public function getStatus(): int
    {
        return (int) $this->getData(static::STATUS);
    }

    /**
     * Returns when was created request
     *
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->getData(static::CREATED_AT);
    }

    /**
     * Returns true if message was written by admin
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return (bool) $this->getData(static::IS_ADMIN);
    }

    /**
     * Returns customer phone
     *
     * @return string
     */
    public function getPhone(): ?string
    {
        return $this->getData(static::PHONE);
    }

    /**
     * Set Customer id (not required)
     *
     * @param int|null $id
     *
     * @return ContactUsInterface
     */
    public function setCustomerId(?int $id): ContactUsInterface
    {
        return $this->setData(static::CUSTOMER_ID, $id);
    }

    /**
     * Set Customer name
     *
     * @param string $name
     *
     * @return ContactUsInterface
     */
    public function setCustomerName(string $name): ContactUsInterface
    {
        return $this->setData(static::NAME, $name);
    }

    /**
     * Set theme of request
     *
     * @param string $theme
     *
     * @return ContactUsInterface
     */
    public function setTheme(string $theme): ContactUsInterface
    {
        return $this->setData(static::THEME, $theme);
    }

    /**
     * Set message of request
     *
     * @param string $message
     *
     * @return ContactUsInterface
     */
    public function setMessage(string $message): ContactUsInterface
    {
        return $this->setData(static::MESSAGE, $message);
    }

    /**
     * Set customer email (not required if admin)
     *
     * @param string|null $email
     *
     * @return ContactUsInterface
     */
    public function setEmail(?string $email): ContactUsInterface
    {
        return $this->setData(static::EMAIL, $email);
    }

    /**
     * Set reply message id(not required if message is not reply)
     *
     * @param int $replyId
     *
     * @return ContactUsInterface
     */
    public function setReplyId(int $replyId): ContactUsInterface
    {
        return $this->setData(static::REPLY_ID, $replyId);
    }

    /**
     * Set status of request (by default - self::NEW_MESSAGE_STATUS)
     *
     * @param int $status
     *
     * @return ContactUsInterface
     */
    public function setStatus(int $status): ContactUsInterface
    {
        return $this->setData(static::STATUS, $status);
    }

    /**
     * Set admin reply or request(not required, by default: false)
     *
     * @param bool $isAdmin
     *
     * @return ContactUsInterface
     */
    public function setIsAdmin(bool $isAdmin): ContactUsInterface
    {
        return $this->setData(static::IS_ADMIN, (int)$isAdmin);
    }

    /**
     * Set customer phone (not required)
     *
     * @param string $phone
     *
     * @return ContactUsInterface
     */
    public function setPhone(string $phone): ContactUsInterface
    {
        return $this->setData(static::PHONE, $phone);
    }
}
