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
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;

class Index extends AbstractAction implements HttpPostActionInterface
{
    /**#@+
     * Name of ACL resource
     */
    const GRID_VIEW_ACL_RESOURCE='Enco_ContactUs::contact_us_edit';
    /**#@-**/

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
        $this->contactUsRepository = $contactUsRepository;
        $this->contactUsInterfaceFactory = $contactUsInterfaceFactory;
        parent::__construct($context);
    }

    /**
     * Execute method to save model
     *
     * @return ResponseInterface|ResultInterface|void
     */
    public function execute()
    {
        /**
         * @var ContactUsInterface $model
         */
        $model = $this->contactUsInterfaceFactory->create();
        $model
            ->setIsAdmin(true)
            ->setReplyId($this->_request->getParam('reply_id'))
            ->setTheme($this->_request->getParam("theme"))
            ->setMessage($this->_request->getParam("comment"));

        try {
            $this->contactUsRepository->save($model);
            $this->messageManager->addSuccessMessage(__("Answered successfully"));
        } catch (Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }
        return $this->_redirect("contact/actions/preview/id/" . $model->getReplyId());
    }

    /**
     * Check if user is allowed to execute this action
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed(static::GRID_VIEW_ACL_RESOURCE);
    }
}
