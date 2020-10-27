<?php
/**
 * Plugin ModulePlugin
 *
 * @category Smile
 * @package Enco\Module
 * @author Andriy Bednarskiy <bednarsasha@gmail.com>
 * @copyright 2020 Smile
 */
namespace Enco\Module\Plugin;

use Enco\Module\Block\Display;
use Magento\Framework\Phrase;

/**
 * Class ModulePlugin
 * @package Enco\Module\Plugin
 */
class ModulePlugin
{
    /**
     * method afterSayHello
     *
     * @param Display $subject
     * @param $result
     * @return Phrase
     */
    public function afterSayHello(Display $subject, $result)
    {
        return __($result . "This is after Say Hello function");
    }
}
