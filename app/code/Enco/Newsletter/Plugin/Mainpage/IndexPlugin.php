<?php
/**
 * @category Smile
 * @package Enco\Newsletter
 * @author Andriy Bednarskiy
 * @copyright 2020 Smile
 */
namespace Enco\Newsletter\Plugin\Mainpage;

use Enco\Newsletter\Block\Index;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Phrase;

/**
 * Class IndexPlugin
 * @package Enco\Newsletter\Plugin\Mainpage
 */
class IndexPlugin
{
    /**
     * @param Index $subject
     * @param $result
     * @return Phrase
     */
    public function afterDisplayNews(Index $subject, $result)
    {
        $objectManager = ObjectManager::getInstance();
        $customerSession = $objectManager->create('Magento\Customer\Model\Session');
        if ($customerSession->isLoggedIn()) {
            return __("There is nothing to show...");
        } else {
            return $result;
        }
    }
}
