<?php

namespace Magefix\Fixture\Builder\Helper;


use Mage;
use Mage_Checkout_Model_Type_Onepage;
use Mage_Sales_Model_Quote;
use Magefix\Fixture\Builder\Helper;

class Checkout implements Helper
{
    /**
     * @param array $checkoutMethodData
     *
     * @return bool
     *
     */
    public static function isGuestCheckout(array $checkoutMethodData)
    {
        return self::_isCheckoutMethod(Mage_Checkout_Model_Type_Onepage::METHOD_GUEST, $checkoutMethodData);
    }

    /**
     * @param array $checkoutMethodData
     *
     * @return bool
     *
     */
    public static function isRegisterCheckout(array $checkoutMethodData)
    {
        return self::_isCheckoutMethod(Mage_Checkout_Model_Type_Onepage::METHOD_REGISTER, $checkoutMethodData);
    }

    /**
     * @param array $checkoutMethodData
     *
     * @return bool
     *
     */
    public static function isCustomerCheckout(array $checkoutMethodData)
    {
        return self::_isCheckoutMethod(Mage_Checkout_Model_Type_Onepage::METHOD_CUSTOMER, $checkoutMethodData);
    }

    /**
     * @param Mage_Sales_Model_Quote $quote
     *
     * @return Mage_Sales_Model_Order
     *
     */
    public static function quoteServiceSubmitAll(Mage_Sales_Model_Quote $quote)
    {
        $service = Mage::getModel('sales/service_quote', $quote);
        $service->submitAll();

        return $service->getOrder();
    }

    /**
     * Enable specified payment method
     * Example: checkmo
     *
     * @param $method
     */
    public static function enablePaymentMethod($method)
    {
        $method = sprintf("payment/%s/active", $method);
        Mage::getModel('core/config')->saveConfig($method, 1);
    }

    /**
     * Disable specified payment method
     * Example: checkmo
     *
     * @param $method
     */
    public static function disablePaymentMethod($method)
    {
        $method = sprintf("payment/%s/active", $method);
        Mage::getModel('core/config')->saveConfig($method, 0);
    }

    /**
     * @param $method
     * @param $checkoutMethodData
     *
     * @return bool
     */
    private static function _isCheckoutMethod($method, $checkoutMethodData)
    {
        $isGuestCheckout = false;

        if ($checkoutMethodData['method'] == $method) {
            $isGuestCheckout = true;
        }

        return $isGuestCheckout;
    }
}
