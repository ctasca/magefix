<?php

namespace Data\Providers;

use Magefix\Fixtures\Data\Provider;

/**
 * Class ApiUser
 *
 * @package Data\Providers
 * @author  Carlo Tasca <ctasca@sessiondigital.com>
 */
class ApiRole implements Provider
{
    public function getName()
    {
        $random = substr(md5(rand()), 0, 5);

        return 'apirole' . $random;
    }

    public function getRoleType()
    {
        return 'G';
    }
}
