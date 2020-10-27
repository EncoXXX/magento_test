<?php
/**
 * @category Smile
 * @package Enco\Newsletter
 * @author Bednarskiy Andriy <bednarsasha@gmail.com>
 * @copyright 2020 Smile
 */
namespace Enco\Newsletter\Controller\Mainpage;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\Layout;

/**
 * Class Index
 * @package Enco\Newsletter\Controller\Mainpage
 */
class Index extends Action
{
    /**
     * @return ResponseInterface|ResultInterface|Layout
     */
    public function execute()
    {
        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }

    /**
     * Get Customer Session
     * @return mixed
     */
    public function getCustomerSession()
    {
        return $this->customerSession;
    }
}
