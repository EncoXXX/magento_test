<?php
/**
 * @category Smile
 * @package Enco\AdmBlock
 * @author Andriy Bednarskiy <bednarsasha@gmail.com>
 * @copyright 2020 Smile
 */
namespace Enco\AdminBlock\Block;

use Magento\Framework\App\ObjectManager;
use Magento\Framework\View\Element\Template;

/**
 * Class Index
 * @package Enco\AdminBlock\Block
 */
class Index extends Template
{
    /**
     * Scope config from admin settings
     * @var Magento\Framework\App\Config
     */
    protected $_scopeConfig;
    /**
     * Index constructor.
     * @param Template\Context $context
     * @param array $data
     */
    public function __construct(Template\Context $context, array $data = [])
    {
        $object_manager = ObjectManager::getInstance();
        $this->_scopeConfig = $object_manager->create("Magento\Framework\App\Config");
        parent::__construct($context, $data);
    }

    /**
     * Get Allowed Ram
     * @return array
     */
    public function getAllowedRam()
    {
        $array = explode(",", $this->_scopeConfig->getValue("system/allowed_sizes_ram/allowed_sizes_ram_select"));
        if ($array === false) {
            return [];
        }
        return $array;
    }
}
