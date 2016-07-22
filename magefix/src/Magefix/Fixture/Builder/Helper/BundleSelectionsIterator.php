<?php

namespace Magefix\Fixture\Builder\Helper;

/**
 * Class BundleSelectionsIterator
 * @package Magefix\Fixture\Builder\Helper
 * @author  Carlo Tasca <ctasca.d3@gmail.com>
 */
class BundleSelectionsIterator extends \ArrayIterator
{
    private $_bundleProducts = [];

    /**
     * @param array $bundleProducts
     */
    public function setBundleProducts($bundleProducts)
    {
        $this->_bundleProducts = $bundleProducts;
    }



    public function apply()
    {
        $data = $this->getArrayCopy();
        array_walk_recursive($data, [$this, 'traverse']);

        return $data;
    }

    /**
     * array_walk_recursive callback
     *
     * @param $value
     */
    public function traverse(&$value, $index)
    {
        if ($index == 'product_id') {
            $productId = trim($value, '#');
            if (is_numeric($productId) && isset($this->_bundleProducts[$productId])) {
                $value = $this->_bundleProducts[$productId]->getId();
            }
        }
    }
}
