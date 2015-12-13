<?php
/**
 * ShippingMethod.php
 */

namespace Magefix\Fixture\Builder\Helper;


use Mage;

/**
 * Class ShippingMethod
 *
 * @package Magefix\Fixture\Builder\Helper
 * @author  Carlo Tasca <ctasca@sessiondigital.com>
 */
class ShippingMethod
{
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
