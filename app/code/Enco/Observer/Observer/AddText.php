<?php
/**
 * Observer AddText
 *
 * @category Smile
 * @package Enco\Observer
 * @author Andriy Bednarskiy <bednarsasha@gmail.com>
 * @copyright 2020 Smile
 */

namespace Enco\Observer\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

/**
 * Class AddText - Observer
 * @package Enco\Observer\Observer
 */
class AddText implements ObserverInterface
{
    /**
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        /**
         * My name
         * @var name
         */
        $name = $observer->getData("name");

        echo "
            <script>
                console.log(\"My name is {$name}\")
            </script>
        ";
    }
}
