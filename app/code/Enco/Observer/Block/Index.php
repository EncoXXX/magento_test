<?php
/**
 * @category Smile
 * @package Enco\Observer
 * @author Andriy Bednarskiy <bednarsasha@gmail.com>
 * @copyright 2020 Smile
 */
namespace Enco\Observer\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

/**
 * Class Index
 * @package Enco\Observer\Block
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
     * Get USD value
     * @return array;
     */
    public function getUsdToUah()
    {
        /**
         * @var $json string
         */

        /**
         * @var $usd array
         */

        $json = file_get_contents("https://bank.gov.ua/NBUStatService/v1/statdirectory/exchange?json");
        $json = json_decode($json, true);

        $usd = [];

        foreach ($json as $value) {
            if ($value["r030"] == 840) {
                $usd = [
                    "date" => date("Y-m-d (l) H:i:s"),
                    "value" => $value["rate"]
                ];
            }
        }
        return $usd;
    }
}
