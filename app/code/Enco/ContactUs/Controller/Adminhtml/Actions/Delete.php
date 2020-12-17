<?php
/**
 * Delete action for Contact Us admin page
 * @category Smile
 * @package Enco\ContactUs
 * @author Andriy Bednarskiy <bednarsasha@gmail.com>
 * @copyright 2020 Smile
 */

namespace Enco\ContactUs\Controller\Adminhtml\Actions;

use Enco\ContactUs\Api\ContactUsRepositoryInterface;
use Enco\ContactUs\Api\Data\ContactUsInterfaceFactory;
use Enco\ContactUs\Model\ContactUs;
use Magento\Backend\App\AbstractAction;
use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;

/**
 * Class Delete
 * @package Enco\ContactUs\Controller\Adminhtml\Actions
 */
class Delete extends AbstractAction
{
    /**#@+
     * Name of ACL resource
     */
    const VIEW_ACL_RESOURCE = 'Enco_ContactUs::contact_us_delete';
    /**#@-**/

    /**
     * @var ContactUsInterfaceFactory
     */
    protected $modelFactory;

    /**
     * @var ContactUsRepositoryInterface
     */
    protected $modelRepo;

    /**
     * Delete constructor.
     * @param Action\Context $context
     * @param ContactUsInterfaceFactory $modelFactory
     * @param ContactUsRepositoryInterface $modelRepo
     */
    public function __construct(
        Action\Context $context,
        ContactUsInterfaceFactory $modelFactory,
        ContactUsRepositoryInterface $modelRepo
    ) {
        parent::__construct($context);
        $this->modelFactory = $modelFactory;
        $this->modelRepo = $modelRepo;
    }

    /**
     * Execute method for delete action
     *
     * @return ResponseInterface|ResultInterface
     */
    public function execute()
    {
        /**
         * @var ContactUs $model
         */
        $model = $this->modelFactory->create();
        $model->setData($this->_request->getParams());

        try {
            $this->modelRepo->delete($model);
            $this->messageManager->addSuccessMessage("Deleted successfully");
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }
        return $this->_redirect('contact/messages/index');
    }

    /**
     * Check if user is allowed to execute this action
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed(static::VIEW_ACL_RESOURCE);
    }
}
