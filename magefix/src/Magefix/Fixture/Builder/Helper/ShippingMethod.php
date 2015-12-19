<?php

namespace Magefix\Fixture\Builder\Helper;


use Mage;
use Mage_Sales_Model_Quote;
use Magefix\Fixture\Builder\Helper;

/**
 * Class ShippingMethod
 *
 * @package Magefix\Fixture\Builder\Helper
 * @author  Carlo Tasca <ctasca@sessiondigital.com>
 */
class ShippingMethod implements Helper
{
    /**
     * @var array
     */
    private $_shippingData = [];
    /**
     * @var Mage_Sales_Model_Quote
     */
    private $_quote;

    public function __construct(Mage_Sales_Model_Quote $quote, array $data)
    {
        $this->_shippingData = $data;
        $this->_quote = $quote;
    }

    public function addShippingDataToQuote()
    {
        $shippingAddress = $this->_quote->getShippingAddress();
        $shippingAddress->setShippingMethod($this->_shippingData['method']);
        $shippingAddress->setShippingDescription($this->_shippingData['description']);

        if ($this->_shippingData['collect_shipping_rates']) {
            $shippingAddress->setCollectShippingRates(true);
            $shippingAddress->collectShippingRates();
        }

        if ($this->_shippingData['collect_totals']) {
            $this->_quote->collectTotals();
        }

        if ($this->_shippingData['free_shipping']) {
            $this->_quote->setFreeShipping(true);
        }
    }

    /**
     * Enable specified carrier. e.g. flatrate
     *
     * @param string $carrier
     */
    public static function enable($carrier)
    {
        self::_enableOrDisable($carrier, 1);
    }

    /**
     * Disable specified carrier. e.g. flatrate
     *
     * @param string $carrier
     */
    public static function disable($carrier)
    {
        self::_enableOrDisable($carrier, 0);
    }

    /**
     * @param $carrier
     *
     * @return boolean
     *
     */
    public static function isEnabled($carrier)
    {
        return Mage::getStoreConfig('carriers/' . $carrier . '/active');
    }

    /**
     * @param string $carrier
     * @param int    $enable
     */
    protected static function _enableOrDisable($carrier, $enable)
    {
        $carriers = Mage::getSingleton('shipping/config')->getActiveCarriers();

        if (array_key_exists($carrier, $carriers)) {
            Mage::app()->getStore()->setConfig('carriers/' . $carrier . '/active', $enable);
        }
    }
}
