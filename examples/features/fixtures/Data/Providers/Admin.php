<?php
namespace Data\Providers;

use Mage;
use Magefix\Fixtures\Data\Provider;

/**
 * Class Admin
 *
 * Admin user fixture data provider
 *
 * @package Data\Providers
 * @author  Daniel Kidanemariam <danielk@sessiondigital.com>
 */
class Admin implements Provider
{
    public function getUsername()
    {
        $random = substr(md5(rand()), 0, 7);

        return 'admin' . $random;
    }

    public function getFirstname()
    {
        return 'admin';
    }

    public function getLastname()
    {
        return 'admin';
    }

    public function getEmail()
    {
        $random = substr(md5(rand()), 0, 7);

        return 'admin' . $random . '@fixture.com';
    }

    public function getPassword()
    {
        return '123123pass';
    }

    public function getRoleIds()
    {
        return [1];
    }
}
