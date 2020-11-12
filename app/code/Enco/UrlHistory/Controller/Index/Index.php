<?php
/**
 * Index Controller
 * @category Smile
 * @package Enco\UrlHistory
 * @author Andriy Bednarskiy <bednarsasha@gmail.com>
 * @copyright 2020 Smile
 */

namespace Enco\UrlHistory\Controller\Index;


use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;

/**
 * Class Index
 * @package Enco\UrlHistory\Controller\Index
 */
class Index extends \Magento\Framework\App\Action\Action
{

    /**
     * Execute method
     * @return ResponseInterface|ResultInterface|void
     */
    public function execute()
    {
        return $this->resultFactory->create($this->resultFactory::TYPE_PAGE);
    }
}
