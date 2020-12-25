<?php
/**
 * ContactUs block for preview
 *
 * @category Smile
 * @package Enco\ContactUs
 * @author Andrew Bednarskiy <bednarsasha@gmail.com>
 * @copyright 2020 Enco
 */

namespace Enco\ContactUs\Block\Adminhtml;

use Enco\ContactUs\Api\ContactUsRepositoryInterface;
use Enco\ContactUs\Api\Data\ContactUsInterface;
use Magento\Backend\Block\Template;
use Magento\Framework\Api\ExtensibleDataInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Message\ManagerInterface;

/**
 * Class Preview
 */
class Preview extends Template
{
    /**
     * Repository for ContactUs module
     *
     * @var ContactUsRepositoryInterface $contactUsRepository
     */
    protected $contactUsRepository;

    /**
     * Contains main preview message
     *
     * @var int $messageId
     */
    protected $messageId = null;

    /**
     * Message manager
     *
     * @var ManagerInterface
     */
    protected $messageManager;


    /**
     * Preview constructor.
     *
     * @param Template\Context $context
     * @param ContactUsRepositoryInterface $contactUsRepository
     * @param ManagerInterface $messageManager
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        ContactUsRepositoryInterface $contactUsRepository,
        ManagerInterface $messageManager,
        array $data = []
    ) {
        $this->contactUsRepository = $contactUsRepository;
        $this->messageManager = $messageManager;
        parent::__construct($context, $data);
    }

    /**
     * Returns all replied messages with main message
     *
     * @return ExtensibleDataInterface[]
     */
    public function getMessages()
    {
        $collection = null;
        try {
            $collection = $this->contactUsRepository->getWithReplied($this->getMessageId());
        } catch (NoSuchEntityException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }
        $this->messageId = $this->contactUsRepository->getMessageId();

        return $collection->getItems();
    }

    /**
     * Returns message id
     *
     * @return int
     */
    public function getMessageId()
    {
        if ($this->messageId !== null) {
            return $this->messageId;
        }

        return (int) $this->getRequest()->getParam(ContactUsInterface::ID);
    }

    /**
     * Returns url for preview form action
     *
     * @return string
     */
    public function getFormAction()
    {
        return $this->getUrl('contact/post/index');
    }
}
