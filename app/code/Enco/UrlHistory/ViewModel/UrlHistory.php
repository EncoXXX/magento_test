<?php
/**
 * ViewModel class
 * @category Smile
 * @package Enco\UrlHistory
 * @author AndriyBednarskiy <bednarsasha@gmail.com>
 * @copyright 2020 Smile
 */
namespace Enco\UrlHistory\ViewModel;

use Enco\UrlHistory\Api\Data\UrlHistoryInterface;
use Enco\UrlHistory\Api\UrlHistoryRepositoryInterface;
use Enco\UrlHistory\Model\UrlHistory as UrlHistoryModel;
use Enco\UrlHistory\Model\UrlHistoryRepositoryFactory;
use Magento\Framework\Api\Search\SearchCriteria;
use Magento\Framework\Api\Search\SearchResult;
use Magento\Framework\Api\Search\SearchResultFactory;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\View\Element\Block\ArgumentInterface;

/**
 * ViewModel Class UrlHistory
 * @package Enco\UrlHistory\ViewModel
 */
class UrlHistory implements ArgumentInterface
{
    /**
     * @var UrlHistoryRepositoryInterface
     */
    protected $repositoryFactory;

    /**
     * @var SearchCriteriaBuilder
     */
    protected $criteriaBuilder;

    /**
     * @var SearchResultFactory
     */
    protected $searchResultFactory;

    /**
     * UnregisteredUrlHistory constructor.
     * @param UrlHistoryRepositoryFactory $repositoryFactory
     * @param SearchCriteriaBuilder $criteriaBuilder
     * @param SearchResultFactory $searchResultFactory
     */
    public function __construct(
        UrlHistoryRepositoryFactory $repositoryFactory,
        SearchCriteriaBuilder $criteriaBuilder,
        SearchResultFactory $searchResultFactory
    ) {
        $this->criteriaBuilder = $criteriaBuilder;
        $this->repositoryFactory = $repositoryFactory;
        $this->searchResultFactory = $searchResultFactory;
    }

    /**
     * Returns list of unregistered url history
     * @return mixed
     */
    public function getUnregisteredUrlHistory()
    {
        /**
         * @var UrlHistoryRepositoryInterface $repository
         */
        $repository = $this->repositoryFactory->create();

        /**
         * @var SearchCriteria $searchCriteria
         */
        $searchCriteria = $this->criteriaBuilder
            ->addFilter(
                UrlHistoryInterface::CUSTOMER_ID,
                null,
                'null'
            )
            ->addFilter(
                UrlHistoryInterface::IS_ACTIVE,
                UrlHistoryInterface::ENABLED,
                'eq'
            )
            ->create();
        return $repository->getList($searchCriteria);
    }

    /**
     * Returns list of registered url history
     * @return mixed
     */
    public function getRegisteredUrlHistory()
    {
        /**
         * @var UrlHistoryRepositoryInterface $repository
         */
        $repository = $this->repositoryFactory->create();

        /**
         * @var SearchCriteria $searchCriteria
         */
        $searchCriteria = $this->criteriaBuilder
            ->addFilter(
                'main_table.' . UrlHistoryInterface::IS_ACTIVE,
                UrlHistoryInterface::ENABLED,
                'eq'
            )
            ->create();
        return $repository->getListWithCustomer($searchCriteria);
    }

    public function getUnregisteredUrlHistoryShort()
    {
        /**
         * @var SearchResult $searchResult
         */

        $searchResult = $this->getUnregisteredUrlHistory();
        $searchResultShort = $this->searchResultFactory->create();
        $searchResultArrayUrls = [];
        $searchResultArrayUrlsShort = [];

        foreach ($searchResult->getItems() as $item) {
            /**
             * @var UrlHistoryModel $item
             */
            $url = $item->getVisitedUrl();
            if (isset($searchResultArrayUrls[$url]) == false) {
                $searchResultArrayUrls[$url] =
                    [
                        "item" => $item,
                        "count" => 1
                    ];
            } else {
                $searchResultArrayUrls[$url]["count"] = $searchResultArrayUrls[$url]["count"] + 1;
            }
        }
        foreach ($searchResultArrayUrls as $item) {
            $item["item"]->setVisitedUrl($item["item"]->getVisitedUrl() . " ({$item["count"]})");
            $searchResultArrayUrlsShort[] = $item["item"];
        }
        $searchResultShort->setItems($searchResultArrayUrlsShort);
        return $searchResultShort;
    }
}
