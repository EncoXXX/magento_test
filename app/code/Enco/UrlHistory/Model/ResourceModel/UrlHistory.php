<?php
/**
 * Resource Model for UrlHistory
 * @category Smile
 * @package Enco\UrlHistory
 * @author Andriy Bednarskiy <bednarsasha@gmail.com>
 * @copyright 2020 Smile
 */

namespace Enco\UrlHistory\Model\ResourceModel;

use Enco\UrlHistory\Api\Data\UrlHistoryInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Resource model for UrlHistory
 * @package Enco\UrlHistory\Model\ResourceModel
 */
class UrlHistory extends AbstractDb
{

    /**
     * _construct method
     */
    protected function _construct()
    {
        $this->_init('url_history', UrlHistoryInterface::ID);
    }
}
