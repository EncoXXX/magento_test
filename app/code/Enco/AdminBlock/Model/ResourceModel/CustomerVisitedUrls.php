<?php


namespace Enco\AdminBlock\Model\ResourceModel;


use Enco\AdminBlock\Api\Data\CustomerVisitedUrlsInterface;

class CustomerVisitedUrls extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init("customer_visited_urls", CustomerVisitedUrlsInterface::ID);
    }
}
