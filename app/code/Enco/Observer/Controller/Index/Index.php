<?php
/**
 * @category Smile
 * @package Enco\Observer
 * @author Andriy Bednarskiy <bednarsasha@gmail.com>
 * @copyright 2020 Smile
 */
namespace Enco\Observer\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\Layout;

/**
 * Class Index
 * @package Enco\Observer\Controller\Index
 */
class Index extends Action
{
    /**
     * Execute
     * @return ResponseInterface|ResultInterface|Layout
     */
    public function execute()
    {
        $this->_eventManager->dispatch("enco_observer_event", ["name"=>"Andrew"]);
        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }
}
