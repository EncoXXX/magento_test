<?php
/**
 * Observer
 *
 * @category Smile;
 * @package Enco\UrlHistory
 * @author Andriy Bednarskiy <bednarsasha@gmail.com>
 * @copyright 2020 Smile
 */

namespace Enco\UrlHistory\Observer;

use Enco\UrlHistory\Api\Data\UrlHistoryInterface;
use Enco\UrlHistory\Api\UrlHistoryRepositoryInterface;
use Enco\UrlHistory\Model\UrlHistory;
use Enco\UrlHistory\Model\UrlHistoryFactory;
use Enco\UrlHistory\Model\UrlHistoryRepository;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Request\Http;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class LogUrlHistory implements ObserverInterface
{
    /**
     * @var UrlHistoryRepository $urlHistoryRepository
     */
    protected $urlHistoryRepository;

    /**
     * @var UrlHistoryFactory
     */
    protected $urlHistoryFactory;

    /**
     * @var Session $customerSession
     */
    protected $customerSession;

//    public function __construct(
//        UrlHistoryRepositoryInterface $urlHistoryRepository,
//        UrlHistoryFactory $urlHistoryFactory,
//        Session $customerSession
//    ) {
//        $this->urlHistoryRepository = $urlHistoryRepository;
//        $this->urlHistoryFactory = $urlHistoryFactory;
//        $this->customerSession = $customerSession;
//    }
    /**
     * Execute method for observer
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
//        /** @var Http $request */
//        $request = $observer->getRequest();
//        /** @var UrlHistory $model */
//        $model = $this->UrlHistoryFactory->create();
//        $model->setCustomerId($this->customerSession->getCustomerId())
//            ->setVisitedUrl($request->getRequestUri())
//            ->setIsActive(UrlHistoryInterface::ENABLED);
//        $this->urlHistoryRepository->save($model);

    }
}
