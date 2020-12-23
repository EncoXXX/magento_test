<?php
/**
 * Save action for Contact Us admin page
 *
 * @category Smile Smile
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
     * @var ContactUsInterfaceFactory $ContactUsInterfaceFactory
     */
    protected $ContactUsInterfaceFactory;

    /**
     * Repository for ContactUs module
     *
     * @var ContactUsRepositoryInterface;
     */
    protected $ContactUsRepository;

    /**
     * Save constructor.
     *
     * @param Action\Context $context
     * @param ContactUsRepositoryInterface $ContactUsRepository
     * @param ContactUsInterfaceFactory $ContactUsInterfaceFactory
     */
    public function __construct(
        Action\Context $context,
        ContactUsRepositoryInterface $ContactUsRepository,
        ContactUsInterfaceFactory $ContactUsInterfaceFactory
    ) {
        $this->ContactUsInterfaceFactory = $ContactUsInterfaceFactory;
        $this->ContactUsRepository = $ContactUsRepository;
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
        $model = $this->ContactUsInterfaceFactory->create();
        $data = $this->getRequest()->getParams();
        $allowedData = [];

        if (!$this->getRequest()->getParam(ContactUsInterface::ID)) {
            unset($data[ContactUsInterface::ID]);
            $allowedData = $data;
        } else {
            $allowedData[ContactUs::STATUS] = $data[ContactUs::STATUS];
            $allowedData[ContactUs::ID] = $data[ContactUs::ID];
        }

        $model->setData($allowedData);

        try {
            $this->ContactUsRepository->save($model);
            $this->messageManager->addSuccessMessage("Saved successfully");
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
