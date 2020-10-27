<?php
/**
 * @category Smile
 * @package Encp\Override
 * @author Andriy Bednarskiy <bednarsasha@gmail.com>
 * @copyright 2020 Smile
 */
namespace Enco\Override\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

/**
 * Class Index
 * @package Enco\Override\Block
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
}
