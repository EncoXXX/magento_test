<?php
/**
 * Save Button for ContactUs form
 * @category Smile
 * @package Enco\ContactUs
 * @author Andriy Bednarskiy
 * @copyright 2020 Smile
 */
namespace Enco\ContactUs\Block\Adminhtml\Form\Buttons;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Class SaveButton
 * @package Enco\ContactUs\Block\Adminhtml\Form\Buttons
 */
class SaveButton implements ButtonProviderInterface
{

    /**
     * Get Save button data
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
