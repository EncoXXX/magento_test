<?php

namespace Enco\AdminGrid\Controller\Adminhtml\History;

use Enco\UrlHistory\Api\Data\UrlHistoryInterfaceFactory;
use Enco\UrlHistory\Api\UrlHistoryRepositoryInterface;
use Enco\UrlHistory\Model\UrlHistory;
use Magento\Backend\App\AbstractAction;
use Magento\Backend\App\Action;
use Magento\Framework\View\Result\PageFactory;

class Delete extends AbstractAction
{
    const VIEW_ACL_RESOURCE = 'Enco_AdminGrid::url_history_delete';

    protected $pageFactory;
    /**
     * @var UrlHistoryInterfaceFactory
     */
    protected $modelFactory;
    /**
     * @var UrlHistoryRepositoryInterface
     */
    protected $modelRepo;

    /**
     * Delete constructor.
     * @param Action\Context $context
     * @param PageFactory $pageFactory
     * @param UrlHistoryInterfaceFactory $modelFactory
     * @param UrlHistoryRepositoryInterface $modelRepo
     */
    public function __construct(
        Action\Context $context,
        PageFactory $pageFactory,
        UrlHistoryInterfaceFactory $modelFactory,
        UrlHistoryRepositoryInterface $modelRepo
    ) {
        $this->pageFactory = $pageFactory;
        parent::__construct($context);
        $this->modelFactory = $modelFactory;
        $this->modelRepo = $modelRepo;
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        /**
         * @var UrlHistory $model
         */
        $model = $this->modelFactory->create();
        $model->setData($this->_request->getParams());

        try {
            $this->modelRepo->delete($model);
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }

        return $this->_redirect('admingrid/url/history');
    }
}
