<?php
/**
 * @category Smile
 * @package Enco\Module
 * @author Andriy Bednarskiy
 * @copyright 2020 Smile
 */
namespace Enco\AdminBlock\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\Layout;

/**
 * Class Display
 * @package Enco\AdminBlock
 */
class Index extends Action
{
    /**
     * Execute method
     * @return ResponseInterface|ResultInterface|Layout
     */
    public function execute()
    {
        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }
}
