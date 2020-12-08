<?php


namespace Enco\ContactUs\Model\ResourceModel\ContactUs;


use Enco\ContactUs\Model\ContactUs;
use Enco\ContactUs\Model\ResourceModel\ContactUs as ContactUsResourceModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    public function _construct()
    {
        $this->_init(ContactUs::class, ContactUsResourceModel::class);
    }
}
