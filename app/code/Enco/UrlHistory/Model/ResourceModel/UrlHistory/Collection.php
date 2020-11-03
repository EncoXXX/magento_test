<?php
/**
 * Collection of Url History
 * @category Smile
 * @package Enco\UrlHistory
 * @author Andriy Bednarskiy <bednarsasha@gmail.com>
 * @copyright 2020 Smile
 */

namespace Enco\UrlHistory\Model\ResourceModel\UrlHistory;

use Enco\UrlHistory\Model\ResourceModel\UrlHistory;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Enco\UrlHistory\Model\ResourceModel\UrlHistory as UrlHistoryResource;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(UrlHistory::class, UrlHistoryResource::class);
    }
}
