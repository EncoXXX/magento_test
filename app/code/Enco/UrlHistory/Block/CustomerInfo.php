<?php


namespace Enco\UrlHistory\Block;


use Magento\Customer\Model\ResourceModel\CustomerRepository;
use Magento\Framework\View\Element\Template;

class CustomerInfo extends Template
{
    /**
     * @var CustomerRepository $customer;
     */
    protected $customer;

    /**
     * CustomerInfo constructor.
     * @param Template\Context $context
     * @param array $data
     */
    public function __construct(Template\Context $context, array $data = [])
    {
        $this->customer->
        parent::__construct($context, $data);
    }


}
