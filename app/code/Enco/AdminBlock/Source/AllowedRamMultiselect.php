<?php
/**
 * Source file for allowed sizes ram multiselect
 *
 * @category Smile
 * @package Encp\AdminBlock
 * @author Andriy Bednarskiy <bednarsasha@gmail.com>
 * @copyright 2020 Smile
 */

namespace Enco\AdminBlock\Source;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class AllowedRamMultiselect
 * @package Enco\AdminBlock\Source
 */
class AllowedRamMultiselect implements OptionSourceInterface
{

    /**
     * @return array
     */
    public function toOptionArray()
    {
        return [
            [
                'label' => __("DDR3"),
                'value' => [
                    [
                        'label' => 'DDR3_1GB',
                        'value' => 'DDR3_1GB'
                    ],[
                        'label' => 'DDR3_2GB',
                        'value' => 'DDR3_2GB'
                    ],[
                        'label' => 'DDR3_4GB',
                        'value' => 'DDR3_4GB'
                    ],[
                        'label' => 'DDR3_8GB',
                        'value' => 'DDR3_8GB'
                    ],
                ]
            ],[
                'label' => __("DDR4"),
                'value' => [
                    [
                        'label' => 'DDR4_1GB',
                        'value' => 'DDR4_1GB'
                    ],[
                        'label' => 'DDR4_2GB',
                        'value' => 'DDR4_2GB'
                    ],[
                        'label' => 'DDR4_4GB',
                        'value' => 'DDR4_4GB'
                    ],[
                        'label' => 'DDR4_8GB',
                        'value' => 'DDR4_8GB'
                    ],[
                        'label' => 'DDR4_16GB',
                        'value' => 'DDR4_16GB'
                    ],
                ]
            ]
        ];

    }
}
