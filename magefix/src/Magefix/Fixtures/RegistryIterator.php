<?php

namespace Magefix\Fixtures;

use Mage;
use Mage_Core_Model_Abstract;
use Magefix\Fixture\Factory\Builder;

/**
 * Class RegistryIterator
 *
 * @package Magefix\Fixtures
 * @author  Carlo Tasca <ctasca@sessiondigital.com>
 */
class RegistryIterator extends \ArrayObject
{
    /**
     * @param $hook
     *
     */
    public function iterateByHook($hook)
    {
        $registryIteratorIterator = $this->getIterator();

        while ($registryIteratorIterator->valid()) {
            $key        = $registryIteratorIterator->key();
            $entry      = $registryIteratorIterator->current();
            $entryMatch = $this->isEntryMatch($hook, $key);

            if (!empty($entryMatch) && isset($entryMatch[1])) {
                $mageModel = $this->getMageModelForMatch($entryMatch[1]);
                if (!is_null($mageModel) && is_a($mageModel, 'Mage_Core_Model_Abstract')) {
                    $this->_echoRegistryChangeMessage(
                        $mageModel, $entryMatch[1], $entry, $key
                    );
                }
            }

            $registryIteratorIterator->next();
        }
    }

    /**
     * @param string $match
     *
     * @return \Mage_Catalog_Model_Category|\Mage_Catalog_Model_Product|\Mage_Customer_Model_Customer|\Mage_Sales_Model_Order|null
     *
     */
    public function getMageModelForMatch($match)
    {
        $model = null;

        if ($match == Builder::SIMPLE_PRODUCT_FIXTURE_TYPE || $match == Builder::CONFIGURABLE_PRODUCT_FIXTURE_TYPE
            || $match == Builder::BUNDLE_PRODUCT_FIXTURE_TYPE
        ) {
            $model = Mage::getModel('catalog/product');
        } elseif ($match == Builder::CATEGORY_FIXTURE_TYPE) {
            $model = Mage::getModel('catalog/category');
        } elseif ($match == Builder::CUSTOMER_FIXTURE_TYPE) {
            $model = Mage::getModel('customer/customer');
        } elseif ($match == Builder::SALES_ORDER_FIXTURE_TYPE) {
            $model = Mage::getModel('sales/order');
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

    /**
     * @param Mage_Core_Model_Abstract $model
     * @param string                  $fixtureType
     * @param                          $entry
     * @param                          $key
     */
    protected function _echoRegistryChangeMessage(Mage_Core_Model_Abstract $model, $fixtureType, $entry, $key)
    {
        echo $this->_deleteAndUnregisterFixture(
            $model, $fixtureType, $entry, $key
        );
    }

    /**
     * @param Mage_Core_Model_Abstract $model
     * @param string                   $fixtureType
     * @param                          $entry
     * @param                          $key
     *
     * @return string
     * @throws \Exception
     */
    protected function _deleteAndUnregisterFixture(Mage_Core_Model_Abstract $model, $fixtureType, $entry, $key)
    {
        $fixture = $model->load((int)$entry);
        $fixture->delete();
        Builder::unregister($key);

        return $this->_deleteFixtureMessage($fixtureType, $entry);
    }

    /**
     * @param string $fixtureType
     * @param string $entry
     *
     * @return string
     */
    protected function _deleteFixtureMessage($fixtureType, $entry)
    {
        return "-- DELETED {$fixtureType} fixture with ID {$entry}\n";
    }
}
