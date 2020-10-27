<?php

/**
 * Registration
 *
 * @category Smile
 * @package Enco\Override
 * @author Andriy Bednarskiy <bednarsasha@gmail.com>
 * @copyright 2020 Smile
 */

use Magento\Framework\Component\ComponentRegistrar;

ComponentRegistrar::register(
    ComponentRegistrar::MODULE,
    'Enco_Override',
    __DIR__
);

