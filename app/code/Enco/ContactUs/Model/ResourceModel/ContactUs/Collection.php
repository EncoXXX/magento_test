<?php
/**
 * ContactUs collection
 *
 * @category Smile Smile
 * @package Enco\ContactUs
 * @author Andriy Bednarskiy <bednarsasha@gmail.com>
 * @copyright 2020 Enco
 */

namespace Enco\ContactUs\Model\ResourceModel\ContactUs;

use Enco\ContactUs\Model\ContactUs;
use Enco\ContactUs\Model\ResourceModel\ContactUs as ContactUsResourceModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Class Collection
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
