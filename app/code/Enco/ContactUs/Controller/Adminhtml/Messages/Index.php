<?php
/**
 * Admin Controller for grid show
 *
 * @category Smile
 * @package Enco\ContactUs
 * @author Andriy Bednarskiy <bednarsasha@gmail.com>
 * @copyright 2020 Enco
 */

namespace Enco\ContactUs\Controller\Adminhtml\Messages;

use Magento\Backend\App\AbstractAction;
use Magento\Backend\App\Action;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class Index
 */
class Index extends AbstractAction implements HttpGetActionInterface
{
    /**#@+
     * Name of ACL resource
     */
    const GRID_VIEW_ACL_RESOURCE='Enco_ContactUs::contact_us_grid';
    /**#@-**/

    /**
     * Page factory
     *
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * History constructor.
     *
     * @param Action\Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Action\Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * Execute method
     *
     * @return Page
     */
    public function execute()
    {
        /**
         * Page object
         *
         * @var Page $resultPage
         */
        $resultPage = $this->resultPageFactory->create();

        $resultPage->setActiveMenu("Enco_ContactUs::contact_us_menu");
        $resultPage->getConfig()->getTitle()->prepend("Contact Us Messages");

        return $resultPage;
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
