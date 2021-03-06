<?php
/**
 * Edit action for Contact Us admin page
 *
 * @category Smile
 * @package Enco\Preview
 * @author Andriy Bednarskiy <bednarsasha@gmail.com>
 * @copyright 2020 Enco
 */
namespace Enco\ContactUs\Controller\Adminhtml\Actions;

use Magento\Backend\App\AbstractAction;
use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class Preview
 */
class Preview extends AbstractAction
{
    /**#@+
     * Name of ACL resource
     */
    const VIEW_ACL_RESOURCE = 'Enco_ContactUs::contact_us_edit';
    /**#@-**/

    /**
     * Page factory
     *
     * @var PageFactory $pageFactory
     */
    protected $pageFactory;

    /**
     * Add constructor.
     *
     * @param Action\Context $context
     * @param PageFactory $pageFactory
     */
    public function __construct(Action\Context $context, PageFactory $pageFactory)
    {
        $this->pageFactory = $pageFactory;
        parent::__construct($context);
    }

    /**
     * Execute method for edit action
     *
     * @return ResponseInterface|ResultInterface|Page
     */
    public function execute()
    {
        $page = $this->pageFactory->create();
        $page->setActiveMenu('Enco_ContactUs::contact_us_menu');

        return $page;
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
