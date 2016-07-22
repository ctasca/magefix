<?php

namespace Data\Providers;

use Magefix\Fixtures\Data\Provider;

/**
 * Class ApiUser
 *
 * @package Data\Providers
 * @author  Carlo Tasca <ctasca.d3@gmail.com>
 */
class ApiUser implements Provider
{
    public function getUsername()
    {
        $random = substr(md5(rand()), 0, 5);

        return 'apiuser' . $random;
    }

    public function getApiUserEmail()
    {
        $random = substr(md5(rand()), 0, 7);

        return 'apiuser' . $random . '@fixture.com';
    }

    public function getApiKey()
    {
        return 'apikeypass';
    }
}
