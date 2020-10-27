<?php
/**
 * Plugin Info
 * Insert suffix after name, it is exists in admin panel
 *
 * @category Smile
 * @package Enco\AdminBlock
 * @author Andriy Bednarskiy <bednarsasha@gmail.com>
 * @copyright 2020 Smile
 */

namespace Enco\AdminBlock\Plugin;

use Magento\Framework\App\Config;

/**
 * Class Info
 * @package Enco\AdminBlock\Plugin
 */
class Info
{
    /**
     * @var Config
     */
    protected $scopeConfig;

    /**
     * Info constructor.
     * @param Config $scopeConfig
     */
    public function __construct(Config $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @param $subject
     * @param $result
     * @return string
     */
    public function afterGetName($subject, $result)
    {
        if ($this->scopeConfig->getValue("god_mode/details/is_suffix_name_visible")) {
            return $result . " " . $this->scopeConfig->getValue("god_mode/details/suffix_name");
        }
        return $result;
    }
}
