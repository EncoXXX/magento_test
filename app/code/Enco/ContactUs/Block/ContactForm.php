<?php
/**
 * Contact From block
 *
 * @category Smile
 * @package Enco\ContactUs
 * @author Andriy Bednarskiy <bednarsasha@gmail.com>
 * @copyright 2020 Enco
 */

namespace Enco\ContactUs\Block;

use Enco\ContactUs\ViewModel\Data as ContactUsViewModel;
use Magento\Framework\File\Csv;
use Magento\Framework\View\Element\Template;

/**
 * Class ContactForm
 */
class ContactForm extends Template
{
    /**
     * ContactUs ViewModel
     *
     * @var ContactUsViewModel
     */
    protected $viewModel;


    /**
     * ContactForm constructor.
     *
     * @param Template\Context $context
     * @param ContactUsViewModel $viewModel
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        ContactUsViewModel $viewModel,
        array $data = []
    ) {
        $this->viewModel = $viewModel;
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

    /**
     * Returns customer name from form or from customer session
     *
     * @return string
     */
    public function getCustomerName()
    {
        return $this->viewModel->getCustomerName();
    }

    /**
     * Returns customer email from form or from customer session
     *
     * @return string
     */
    public function getCustomerEmail()
    {
        return $this->viewModel->getCustomerEmail();
    }

    /**
     * Returns customer phone from form
     *
     * @return string
     */
    public function getCustomerPhone()
    {
        return $this->viewModel->getCustomerPhone();
    }

    /**
     * Returns theme from form
     *
     * @return string
     */
    public function getTheme()
    {
        return $this->viewModel->getTheme();
    }

    /**
     * Returns comment from form
     *
     * @return string
     */
    public function getComment()
    {
        return $this->viewModel->getComment();
    }
}
