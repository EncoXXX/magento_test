<?php
/**
 * @category Smile
 * @package Enco\Module
 * @author Andriy Bednarskiy <bednarsasha@gmail.com>
 * @copyright 2020 Smile
 */
namespace Enco\Module\Block;

use Magento\Framework\Phrase;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

/**
 * Class Display
 * @package Enco\Module\Block
 */
class Display extends Template
{
    /**
     * Display constructor.
     * @param Context $context
     * @param array $data
     */
    public function __construct(Context $context, array $data = [])
    {
        parent::__construct($context, $data);
    }

    /**
     * Say hello (but says TADAAAAAAAM)
     * @return Phrase
     */
    public function SayHello()
    {
        return __("Ta-daaaaaam!!!");
    }


}
