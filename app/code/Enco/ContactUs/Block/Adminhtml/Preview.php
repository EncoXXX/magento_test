<?php
/**
 * ContactUs block for preview
 * @category Smile
 * @package Enco\ContactUs
 * @author Andrew Bednarskiy <bednarsasha@gmail.com>
 * @copyright 2020 Smile
 */

namespace Enco\ContactUs\Block\Adminhtml;

use Enco\ContactUs\Api\ContactUsRepositoryInterface;
use Enco\ContactUs\Api\Data\ContactUsInterface;
use Enco\ContactUs\Model\ContactUs;
use Magento\Backend\Block\Template;
use Magento\Framework\DataObject;

/**
 * Class Preview
 * @package Smile\Customer\Block\Adminhtml
 */
class Preview extends Template
{
    /**
     * @var ContactUsRepositoryInterface $contactUsRepository
     */
    protected $contactUsRepository;

    /**
     * Preview constructor.
     * @param Template\Context $context
     * @param ContactUsRepositoryInterface $contactUsRepository
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        ContactUsRepositoryInterface $contactUsRepository,
        array $data = []
    ) {
        $this->contactUsRepository = $contactUsRepository;
        parent::__construct($context, $data);
    }

    /**
     * Returns all replied messages with main message
     * @return ContactUs[]
     */
    public function getModel()
    {
        return $this->contactUsRepository->getWithReplied($this->getMessageId());
    }

    /**
     * Returns message id
     * @return int
     */
    public function getMessageId()
    {
        return (int) $this->getRequest()->getParam(ContactUsInterface::ID);
    }

    /**
     * Returns url for preview form action
     * @return string
     */
    public function getFormAction()
    {
        return $this->getUrl('contact/post/index');
    }
}
