<?php
/**
 * ContactUs collection
 * @category Smile
 * @package Enco\ContactUs
 * @author Andriy Bednarskiy <bednarsasha@gmail.com>
 * @copyright 2020 smile
 */

namespace Enco\ContactUs\Model\ResourceModel\ContactUs;

use Enco\ContactUs\Model\ContactUs;
use Enco\ContactUs\Model\ResourceModel\ContactUs as ContactUsResourceModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Class Collection
 * @package Enco\ContactUs\Model\ResourceModel\ContactUs
 */
class Collection extends AbstractCollection
{
    /**
     * construct method for collection (warning: "_", not "__")
     */
    public function _construct()
    {
        $this->_init(ContactUs::class, ContactUsResourceModel::class);
    }
}
