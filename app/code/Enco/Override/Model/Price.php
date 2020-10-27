<?php
/**
 * @category Smile
 * @package Enco\Override
 * @author Andriy Bednarskiy <bednarsasha@gmail.com>
 */

namespace Enco\Override\Model;

use Magento\Catalog\Model\Product\Type\Price as Price_old;

/**
 * Class Product
 * @package Enco\Override\Model
 */
class Price extends Price_old
{
    public function getPrice($product)
    {
        return $product->getData('price') * 100; // TODO: Change the autogenerated stub
    }
}
