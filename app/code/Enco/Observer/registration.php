<?php
/**
 * Registration
 *
 * @category Smile
 * @package Enco\Observer
 * @author Andriy Bednarskiy <bednarsasha@gmail.com>
 * @copyright 2020 Smile
 */

use Magento\Framework\Component\ComponentRegistrar;

ComponentRegistrar::register(
    ComponentRegistrar::MODULE,
    'Enco_Observer',
    __DIR__
);
