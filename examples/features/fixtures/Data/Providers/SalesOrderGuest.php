<?php

namespace Data\Providers;


use Mage;
use Mage_Checkout_Model_Type_Onepage;
use Magefix\Fixtures\Data\Provider;

/**
 * Class SalesOrder
 *
 * @package Data\Providers
 * @author  Carlo Tasca <ctasca@sessiondigital.com>
 */
class SalesOrderGuest implements Provider
{
    public function getStoreId()
    {
        return Mage::app()->getStore('default')->getId();
    }

    public function getRegion()
    {
        return 'Greater London';
    }

    public function getShippingCarrier()
    {
        return 'freeshipping';
    }

    public function getShippingMethod()
    {
        return 'freeshipping_freeshipping';
    }

    public function getShippingMethodDescription()
    {
        return 'Free Shipping';
    }

    public function getCheckoutMethod()
    {
        return Mage_Checkout_Model_Type_Onepage::METHOD_GUEST;
    }

    public function getPaymentMethod()
    {
        return 'checkmo';
    }

    public function getCustomerEmail()
    {
        $random = substr(md5(rand()), 0, 7);

        return 'customer' . $random . '@fixture.com';
    }

}
