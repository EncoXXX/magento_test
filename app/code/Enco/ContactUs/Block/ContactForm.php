<?php
/**
 * Contact From block
 *
 * @category Smile Smile
 * @package Enco\ContactUs
 * @author Andriy Bednarskiy <bednarsasha@gmail.com>
 * @copyright 2020 Enco
 */

namespace Enco\ContactUs\Block;

use Magento\Framework\View\Element\Template;

/**
 * Class Temp
 */
class ContactForm extends Template
{
    /**
     * ContactForm constructor.
     *
     * @param Template\Context $context
     * @param array $data
     */
    public function __construct(Template\Context $context, array $data = [])
    {
        parent::__construct($context, $data);
    }

    /**
     * Returns url for contact form action
     *
     * @return string
     */
    public function getFormAction()
    {
        return $this->getUrl('contact/index/post', ['_secure' => true]);
    }
}
