<?php
/**
 * Registration file
 * @catecory Smile
 * @package Enco\AdminGrid
 * @author Andriy Bednarskiy <bednarsasha@gmail.com>
 * @copyright 2020 Smile
 */

namespace Enco\AdminGrid;

use Magento\Framework\Component\ComponentRegistrar;

ComponentRegistrar::register(
    ComponentRegistrar::MODULE,
    'Enco_AdminGrid',
    __DIR__
);
