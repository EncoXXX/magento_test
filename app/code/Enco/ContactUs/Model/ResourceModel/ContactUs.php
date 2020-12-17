<?php
/**
 * Resource model for ContactUs
 * @category Smile
 * @package Enco\ContactUs
 * @author Andriy Bednarskiy <bednarsasha@gmail.com>
 * @copyright 2020 Smile
 */

namespace Enco\ContactUs\Model\ResourceModel;


use Enco\ContactUs\Api\Data\ContactUsInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Resource Model ContactUs
 * @package Enco\ContactUs\Model\ResourceModel
 */
class ContactUs extends AbstractDb
{

    /**
     * _construct method
     */
    protected function _construct()
    {
        $this->_init(ContactUsInterface::TABLE_NAME, ContactUsInterface::ID);
    }
}
