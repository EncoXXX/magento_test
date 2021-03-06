<?php

namespace Enco\AdminGrid\Controller\Adminhtml\History;

use Magento\Backend\App\AbstractAction;
use Magento\Backend\App\Action;
use Magento\Framework\View\Result\PageFactory;

class Add extends AbstractAction
{
    const VIEW_ACL_RESOURCE = 'Enco_AdminGrid::contact_us_edit';

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
     * Execute method for action add (forward to edit)
     */
    public function execute()
    {
        $this->_forward('edit');
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed(static::VIEW_ACL_RESOURCE);
    }
}
