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
use Enco\UrlHistory\Model\UrlHistoryRepositoryFactory;
use Magento\Framework\Api\Search\SearchCriteria;
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
     * UnregisteredUrlHistory constructor.
     * @param UrlHistoryRepositoryFactory $repositoryFactory
     * @param SearchCriteriaBuilder $criteriaBuilder
     */
    public function __construct(
        UrlHistoryRepositoryFactory $repositoryFactory,
        SearchCriteriaBuilder $criteriaBuilder
    ) {
        $this->criteriaBuilder = $criteriaBuilder;
        $this->repositoryFactory = $repositoryFactory;
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
}
