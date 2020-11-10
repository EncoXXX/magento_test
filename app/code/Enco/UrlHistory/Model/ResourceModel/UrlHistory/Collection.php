<?php
/**
 * Collection of Url History
 * @category Smile
 * @package Enco\UrlHistory
 * @author Andriy Bednarskiy <bednarsasha@gmail.com>
 * @copyright 2020 Smile
 */

namespace Enco\UrlHistory\Model\ResourceModel\UrlHistory;

use Enco\UrlHistory\Model\ResourceModel\UrlHistory as UrlHistoryResource;
use Enco\UrlHistory\Model\UrlHistory;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Class Collection for UrlHistory
 * @package Enco\UrlHistory\Model\ResourceModel\UrlHistory
 */
class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(UrlHistory::class, UrlHistoryResource::class);
    }

    public function joinCustomerTable()
    {
        $this->join(
            $this->getTable("customer_entity"),
            "main_table.customer_id=" . $this->getTable("customer_entity") . ".entity_id",
            ['email','firstname','lastname']
        );
    }
}
