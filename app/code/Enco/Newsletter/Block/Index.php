<?php
/**
 * Block
 *
 * @category Smile
 * @package Enco\Newsletter
 * @author Andriy Bednarskiy <bednarsasha@gmail.com>
 * @copyright 2020 Smile
 */
namespace Enco\Newsletter\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

/**
 * Class Index
 * @package Enco\Newsletter\Block
 */
class Index extends Template
{
    /**
     * Index constructor.
     * @param Context $context
     * @param array $data
     */
    public function __construct(Context $context, array $data = [])
    {
        parent::__construct($context, $data);
    }

    /**
     * Display News
     * @return string
     */
    public function displayNews()
    {
        return "
            <div style='border:1px solid grey; width: 700px; padding: 0px 35px 35px;'>
                <h2>Some news</h2>
                <hr>
                <p>Some content...</p>
            </div>
        ";
    }
}
