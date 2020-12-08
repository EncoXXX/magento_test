<?php

namespace Enco\AdminGrid\Controller\Adminhtml\History;

use Magento\Backend\App\AbstractAction;
use Magento\Backend\App\Action;
use Magento\Framework\View\Result\PageFactory;

class Edit extends AbstractAction
{
    const VIEW_ACL_RESOURCE = 'Enco_AdminGrid::url_history_edit';

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
     * @inheritDoc
     */
    public function execute()
    {
        $page = $this->pageFactory->create();
        $page->getConfig()->getTitle()->prepend("Boom");
        $page->setActiveMenu('Enco_AdminGrid::url_history_menu');
        return $page;
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed(static::VIEW_ACL_RESOURCE);
    }
}
