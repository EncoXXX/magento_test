<?php
/**
 * Plugin to override Magento\Contact\Controller\Index\Index
 * @see Magento\Contact\Controller\Index\
 * @category Smile
 * @package Enco\ContactUs
 * @author Andriy Bednarskiy <bednarsasha@gmail.com>
 * @copyright 2020 Smile
 */

namespace Enco\ContactUs\Plugin\Controller\Index;

use Magento\Contact\Controller\Index\Index as OverrideObject;

/**
 * Class IndexPlugin
 * @package Enco\ContactUs\Plugin\Controller\Index
 */
class IndexPlugin
{
    /**
     * IndexPlugin constructor.
     */
    public function __construct()
    {
    }

    /**
     * Override execute method of OverrideObject
     * @param OverrideObject $object
     * @param callable $proceed
     * @return mixed
     */
    public function aroundExecute(OverrideObject $object, callable $proceed)
    {
//        echo "<h1>AAAAAA</h1>";
        return $proceed();
    }
}
