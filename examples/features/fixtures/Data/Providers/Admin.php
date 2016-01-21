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
        return 'testadmin';
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
        return 'testadmin@example.com';
    }

    public function getPassword()
    {
        return '123123pass';
    }
}