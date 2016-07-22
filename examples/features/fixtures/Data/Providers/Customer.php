<?php

namespace Data\Providers;

use Magefix\Fixtures\Data\Provider;
use Mage;

/**
 * Class Customer
 *
 * Customer fixture data provider
 *
 * @package Data\Providers
 * @author  Carlo Tasca <ctasca.d3@gmail.com>
 */
class Customer implements Provider
{
    public function getWebsiteId()
    {
        return Mage::app()->getWebsite()->getId();
    }

    public function getStore()
    {
        return Mage::app()->getStore();
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
