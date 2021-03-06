<?php
/**
 * Save Button for form
 *
 * @category Smile
 * @package Enco\AdminGrid
 * @author Andriy Bednarskiy
 * @copyright 2020 Smile
 */
namespace Enco\AdminGrid\Block\Adminhtml\UrlHistory\Form\Buttons;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Class SaveButton
 * @package Enco\AdminGrid\Block\Adminhtml\UrlHistory\Form\Buttons
 */
class SaveButton implements ButtonProviderInterface
{

    /**
     * Get Button data
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label' => __('Save Data'),
            'class' => 'save primary',
            'data_attribute' => [
                'mage_init' => [
                    'button' => [
                        'event' => 'save'
                    ]
                ],
                'form-role' => 'save'
            ],
            'sort_order' => 90
        ];
    }
}
