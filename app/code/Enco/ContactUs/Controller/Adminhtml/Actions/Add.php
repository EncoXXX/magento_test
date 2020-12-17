<?php
/**
 * Add action for Contact Us admin page
 * @category Smile
 * @package Enco\ContactUs
 * @author Andriy Bednarskiy <bednarsasha@gmail.com>
 * @copyright 2020 Smile
 */
namespace Enco\ContactUs\Controller\Adminhtml\Actions;

use Magento\Backend\App\AbstractAction;
use Magento\Backend\App\Action;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class Add
 * @package Enco\ContactUs\Controller\Adminhtml\Actions
 */
class Add extends AbstractAction
{
    /**#@+
     * Name of ACL resource
     */
    const VIEW_ACL_RESOURCE = 'Enco_ContactUs::contact_us_edit';
    /**#@-**/

    /**
     * @var PageFactory $pageFactory
     */
    protected $pageFactory;

    /**
     * Add constructor.
     * @param Action\Context $context
     * @param PageFactory $pageFactory
     */
    public function __construct(Action\Context $context, PageFactory $pageFactory)
    {
        $this->pageFactory = $pageFactory;
        parent::__construct($context);
    }

    /**
     * Execute method (forward to edit)
     */
    public function execute()
    {
        $this->_forward('edit');
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
