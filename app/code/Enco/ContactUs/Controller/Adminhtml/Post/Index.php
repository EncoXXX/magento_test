<?php
/**
 * Save action for preview form
 * @category Smile
 * @package Enco\ContactUs
 * @author Andriy Bednarskiy <bednarsasha@gmail.com>
 * @copyright 2020 Smile
 */

namespace Enco\ContactUs\Controller\Adminhtml\Post;

use Enco\ContactUs\Api\ContactUsRepositoryInterface;
use Enco\ContactUs\Api\Data\ContactUsInterface;
use Enco\ContactUs\Api\Data\ContactUsInterfaceFactory;
use Exception;
use Magento\Backend\App\AbstractAction;
use Magento\Backend\App\Action;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;

class Index extends AbstractAction implements HttpGetActionInterface
{

    /**
     * @var ContactUsRepositoryInterface
     */
    protected $contactUsRepository;
    /**
     * @var ContactUsInterfaceFactory
     */
    protected $contactUsInterfaceFactory;

    /**
     * Index constructor.
     * @param ContactUsRepositoryInterface $contactUsRepository
     * @param ContactUsInterfaceFactory $contactUsInterfaceFactory
     * @param Action\Context $context
     */
    public function __construct(
        ContactUsRepositoryInterface $contactUsRepository,
        ContactUsInterfaceFactory $contactUsInterfaceFactory,
        Action\Context $context
    ) {
        parent::__construct($context);
        $this->contactUsRepository = $contactUsRepository;
        $this->contactUsInterfaceFactory = $contactUsInterfaceFactory;
    }

    /**
     * Execute method to save model
     * @return ResponseInterface|ResultInterface|void
     */
    public function execute()
    {
        $model = $this->contactUsInterfaceFactory->create();
        $model
            ->setStatus(ContactUsInterface::REPLIED_STATUS)
            ->setCustomerName("Admin")
            ->setEmail("admin@smile-m2.lxc")
            ->setIsAdmin(true)
            ->setPhone("+380991111111")
            ->setReplyId($this->_request->getParam('reply_id'))
            ->setTheme($this->_request->getParam("theme"))
            ->setMessage($this->_request->getParam("comment"));

        $oldMessageModel = $this->contactUsInterfaceFactory->create();
        $oldMessageModel->setId($this->_request->getParam("reply_id"));
        $oldMessageModel->setStatus(ContactUsInterface::REPLIED_STATUS);

        try {
            $this->contactUsRepository->save($model);
            $this->contactUsRepository->save($oldMessageModel);
            $this->messageManager->addSuccessMessage(__("Answered successfully"));
        } catch (Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }
        return $this->resultRedirectFactory->create()->setPath("contact/actions/preview");
    }
}
