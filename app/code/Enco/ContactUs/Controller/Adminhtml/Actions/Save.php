<?php
/**
 * Save action for Contact Us admin page
 *
 * @category Smile
 * @package Enco\ContactUs
 * @author Andriy Bednarskiy <bednarsasha@gmail.com>
 * @copyright 2020 Enco
 */

namespace Enco\ContactUs\Controller\Adminhtml\Actions;

use Enco\ContactUs\Api\ContactUsRepositoryInterface;
use Enco\ContactUs\Api\Data\ContactUsInterface;
use Enco\ContactUs\Api\Data\ContactUsInterfaceFactory;
use Enco\ContactUs\Model\ContactUs;
use Exception;
use Magento\Backend\App\AbstractAction;
use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class Save
 */
class Save extends AbstractAction
{
    /**#@+
     * Name of ACL resource
     */
    const SAVE_ACL_RESOURCE = 'Enco_ContactUs::contact_us_save';
    /**#@-**/

    /**
     * Factory for ContactUs model
     *
     * @var ContactUsInterfaceFactory $contactUsInterfaceFactory
     */
    protected $contactUsInterfaceFactory;

    /**
     * Repository for ContactUs module
     *
     * @var ContactUsRepositoryInterface;
     */
    protected $contactUsRepository;

    /**
     * Save constructor.
     *
     * @param Action\Context $context
     * @param ContactUsRepositoryInterface $contactUsRepository
     * @param ContactUsInterfaceFactory $contactUsInterfaceFactory
     */
    public function __construct(
        Action\Context $context,
        ContactUsRepositoryInterface $contactUsRepository,
        ContactUsInterfaceFactory $contactUsInterfaceFactory
    ) {
        $this->сontactUsInterfaceFactory = $contactUsInterfaceFactory;
        $this->сontactUsRepository = $contactUsRepository;
        parent::__construct($context);
    }

    /**
     * Execute method for save action
     *
     * @return ResponseInterface|ResultInterface
     */
    public function execute()
    {
        /**
         * ContactUs model
         *
         * @var ContactUs $model;
         */
        $model = $this->contactUsInterfaceFactory->create();
        $data = $this->getRequest()->getParams();
        $allowedData = [];

        if (!$this->getRequest()->getParam(ContactUsInterface::ID)) {
            unset($data[ContactUsInterface::ID]);
            $allowedData = $data;
        } else {
            $allowedData[ContactUs::STATUS] = $data[ContactUs::STATUS];
            $allowedData[ContactUs::ID] = $data[ContactUs::ID];
            $model->setIsAdminEdit(true);
        }

        $model->setData($allowedData);

        try {
            $this->contactUsRepository->save($model);
            $this->messageManager->addSuccessMessage(__("Saved successfully"));
        } catch (Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }

        return $this->_redirect('contact/actions/edit', [ContactUsInterface::ID=>$model->getId()]);
    }

    /**
     * Check if user is allowed to execute this action
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed(static::SAVE_ACL_RESOURCE);
    }
}
