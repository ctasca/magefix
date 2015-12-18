<?php

namespace Data\Providers;

use Mage_Checkout_Model_Type_Onepage;
use Magefix\Fixtures\Data\Provider;

/**
 * Class SalesOrder
 *
 * @package Data\Providers
 * @author  Carlo Tasca <ctasca@sessiondigital.com>
 */
class SalesOrderCustomer extends SalesOrderRegister implements Provider
{
    public function getCheckoutMethod()
    {
        return Mage_Checkout_Model_Type_Onepage::METHOD_CUSTOMER;
    }
}
