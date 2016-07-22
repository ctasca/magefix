<?php

namespace Data\Providers;


use Mage;
use Mage_Checkout_Model_Type_Onepage;
use Magefix\Fixtures\Data\Provider;

/**
 * Class SalesOrder
 *
 * @package Data\Providers
 * @author  Carlo Tasca <ctasca.d3@gmail.com>
 */
class SalesOrderRegister extends SalesOrderGuest implements Provider
{
    public function getWebsiteId()
    {
        return Mage::app()->getWebsite()->getId();
    }

    public function getStore()
    {
        return Mage::app()->getStore();
    }

    public function getCheckoutMethod()
    {
        return Mage_Checkout_Model_Type_Onepage::METHOD_REGISTER;
    }

    public function getCustomerEmail()
    {
        $random = substr(md5(rand()), 0, 7);

        return 'customer' . $random . '@fixture.com';
    }

    public function getRegion()
    {
        return 'Greater London';
    }

}
