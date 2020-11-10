<?php
/**
 * Block class
 * @category Smile
 * @package Enco\UrlHistory
 * @author Andriy Bednarskiy <bednarsasha@gmail.com>
 * @copyright 2020 Smile
 */
namespace Enco\UrlHistory\Block;

use Enco\UrlHistory\ViewModel\UrlHistory as UrlHistoryViewModel;
use Magento\Framework\View\Element\Template;

class Index extends Template
{
    /**
     * @var UrlHistoryViewModel
     */
    public $urlHistoryViewModel;

    /**
     * Index constructor for block
     * @param Template\Context $context
     * @param UrlHistoryViewModel $urlHistoryViewModel
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        UrlHistoryViewModel $urlHistoryViewModel,
        array $data = []
    ) {
        $this->urlHistoryViewModel = $urlHistoryViewModel;
        parent::__construct($context, $data);
    }


}
