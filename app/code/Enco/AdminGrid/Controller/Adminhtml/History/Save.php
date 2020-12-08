<?php

namespace Enco\AdminGrid\Controller\Adminhtml\History;

use Enco\UrlHistory\Api\Data\UrlHistoryInterface;
use Enco\UrlHistory\Api\Data\UrlHistoryInterfaceFactory;
use Enco\UrlHistory\Api\UrlHistoryRepositoryInterface;
use Enco\UrlHistory\Model\UrlHistory;
use Exception;
use Magento\Backend\App\AbstractAction;
use Magento\Backend\App\Action;
use Magento\Framework\View\Result\PageFactory;

class Save extends AbstractAction
{
    const SAVE_ACL_RESOURCE = 'Enco_AdminGrid::url_history_save';

    /**
     * Save constructor.
     * @param Action\Context $context
     * @param PageFactory $pageFactory
     */

    /**
     * @var UrlHistoryInterfaceFactory $urlHistoryInterfaceFactory
     */
    protected $urlHistoryInterfaceFactory;

    /**
     * @var UrlHistoryRepositoryInterface;
     */
    protected $urlHistoryRepository;

    /**
     * Save constructor.
     * @param Action\Context $context
     * @param UrlHistoryRepositoryInterface $urlHistoryRepository
     * @param UrlHistoryInterfaceFactory $urlHistoryInterfaceFactory
     */
    public function __construct(
        Action\Context $context,
        UrlHistoryRepositoryInterface $urlHistoryRepository,
        UrlHistoryInterfaceFactory $urlHistoryInterfaceFactory
    ) {
        $this->urlHistoryInterfaceFactory = $urlHistoryInterfaceFactory;
        $this->urlHistoryRepository = $urlHistoryRepository;
        parent::__construct($context);
    }

    public function execute()
    {
        /**
         * @var UrlHistory $model;
         */
        $model = $this->urlHistoryInterfaceFactory->create();
        $data = $this->getRequest()->getParams();
        if (!$this->getRequest()->getParam(UrlHistoryInterface::ID)) {
            unset($data[UrlHistoryInterface::ID]);
        }

        $model->setData($data);

        try {
            $this->urlHistoryRepository->save($model);
        } catch (Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }
        return $this->_redirect('admingrid/history/edit', [UrlHistoryInterface::ID=>$model->getId()]);
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed(static::SAVE_ACL_RESOURCE);
    }
}
