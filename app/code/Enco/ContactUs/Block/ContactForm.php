<?php
/**
 * Contact From block
 * @category Smile
 * @package Enco\ContactUs
 * @author Andriy Bednarskiy <bednarsasha@gmail.com>
 * @copyright 2020 Smile
 */

namespace Enco\ContactUs\Block;

use Magento\Framework\View\Element\Template;

/**
 * Class Temp
 * @package Enco\ContactUs\Block
 */
class ContactForm extends Template
{
    /**
     * Temp constructor.
     * @param Template\Context $context
     * @param array $data
     */
    public function __construct(Template\Context $context, array $data = [])
    {
        parent::__construct($context, $data);
    }

    /**
     * Returns url for contact form action
     * @return string
     */
    public function getFormAction()
    {
        return $this->getUrl('contact/index/post', ['_secure' => true]);
    }
}
