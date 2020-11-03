<?php
/**
 * @category Smile
 * @package Enco\Module
 * @author Andriy Bednarskiy
 * @copyright 2020 Smile
 */
namespace Enco\AdminBlock\Controller\Index;

use Enco\AdminBlock\Api\Data\CustomerVisitedUrlsInterface;
use Enco\AdminBlock\Model\CustomerVisitedUrls;
use Magento\Cms\Api\BlockRepositoryInterface;
use Magento\Cms\Api\GetBlockByIdentifierInterface;
use Magento\Framework\Api\SearchCriteriaInterface as SearchCriteriaInterfaceAlias;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Result\Layout;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class Display
 * @package Enco\AdminBlock
 */
class Index extends Action
{
    const BLOCK_IDENTIFIER = 'women-block';
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var GetBlockByIdentifierInterface
     */
    protected $getBlockByIdentifier;

    /**
     * @var BlockRepositoryInterface
     */
    protected $blockRepository;

    /**
     * @var SearchCriteriaInterfaceAlias
     */
    protected $searchCriteria;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        GetBlockByIdentifierInterface $getBlockByIdentifier,
        BlockRepositoryInterface $blockRepository,
        SearchCriteriaInterfaceAlias $searchCriteria
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->getBlockByIdentifier = $getBlockByIdentifier;
        $this->blockRepository = $blockRepository;
        $this->searchCriteria = $searchCriteria;
    }

    /**
     * Execute method
     * @return ResponseInterface|ResultInterface|Layout
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function execute()
    {
        $page = $this->resultPageFactory->create();
        $block = $this->getBlockByIdentifier->execute(self::BLOCK_IDENTIFIER, 0);
        $collection = $this->blockRepository->getList($this->searchCriteria);
//        var_dump($block->getId());
//        var_dump($block);
//        var_dump($collection);
//        $myBlock = $this->customerVisitedUrls->getCustomerId();
//        var_dump($myBlock);
        return $page;
    }
}
