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
use Enco\UrlHistory\Model\UrlHistoryFactory;
use Enco\UrlHistory\Model\UrlHistoryRepository;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Request\Http;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Exception\LocalizedException;

/**
 * Observer LogUrlHistory
 * @package Enco\UrlHistory\Observer
 */
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

    public function __construct(
        UrlHistoryRepositoryInterface $urlHistoryRepository,
        UrlHistoryFactory $urlHistoryFactory,
        Session $customerSession
    ) {
        $this->urlHistoryRepository = $urlHistoryRepository;
        $this->urlHistoryFactory = $urlHistoryFactory;
        $this->customerSession = $customerSession;
    }

    /**
     * Execute method for observer
     * @param Observer $observer
     * @throws LocalizedException
     */
    public function execute(Observer $observer)
    {
        /** @var Http $request */
        $request = $observer->getRequest();
        $model = $this->urlHistoryFactory->create();

        /**
         * @var string|null $name
         */
        $name = $this->customerSession->getCustomer()->getName();
        if (trim($name) == '') {
            $name = null;
        }

        $model->setCustomerId($this->customerSession->getCustomerId() ?: null)
            ->setVisitedUrl($request->getRequestString() ?: "none")
            ->setIsActive(UrlHistoryInterface::ENABLED)
            ->setCustomerName($name);
        $answer = $this->urlHistoryRepository->save($model);
        if ($answer == null) {
            echo __("Cant save data(");
        }
    }
}
