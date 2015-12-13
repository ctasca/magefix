<?php
/**
 * RegistryIterator.php
 */

namespace Magefix\Fixtures;

use Mage;
use Magefix\Fixture\Factory\Builder;

/**
 * Class RegistryIterator
 *
 * @package Magefix\Fixtures
 * @author  Carlo Tasca <ctasca@sessiondigital.com>
 */
class RegistryIterator extends \ArrayObject
{
    public function getMageModelForMatch($match)
    {
        $model = null;

        if ($match == Builder::SIMPLE_PRODUCT_FIXTURE_TYPE || $match == Builder::CONFIGURABLE_PRODUCT_FIXTURE_TYPE
            || $match == Builder::BUNDLE_PRODUCT_FIXTURE_TYPE
        ) {
            $model = Mage::getModel('catalog/product');
        } elseif($match == Builder::CATEGORY_FIXTURE_TYPE) {
            $model = Mage::getModel('catalog/category');
        } elseif($match == Builder::CUSTOMER_FIXTURE_TYPE) {
            $model =  Mage::getModel('customer/customer');
        } elseif($match == Builder::SALES_ORDER_FIXTURE_TYPE) {
            $model =  Mage::getModel('sales/order');
        }

        return $model;
    }

    /**
     * @param $hook
     * @param $key
     *
     * @return array
     *
     */
    public function isEntryMatch($hook, $key)
    {
        $matches = [];
        $matchOr = Builder::SIMPLE_PRODUCT_FIXTURE_TYPE . '|' . Builder::BUNDLE_PRODUCT_FIXTURE_TYPE
            . '|' . Builder::CONFIGURABLE_PRODUCT_FIXTURE_TYPE . '|' . Builder::CUSTOMER_FIXTURE_TYPE
            . '|' . Builder::CATEGORY_FIXTURE_TYPE . '|' . Builder::SALES_ORDER_FIXTURE_TYPE;

        preg_match("/^({$matchOr})_{$hook}/", $key, $matches);

        return $matches;
    }
}
