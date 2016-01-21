<?php

namespace Magefix\Fixture\Builder;

use Magefix\Fixture\Builder\Helper\ApiUser as ApiUserHelper;
use Magefix\Fixture\Factory\Builder;
use Magefix\Fixture\Instanciator;

/**
 * Class ApiUser
 * @package Magefix\Fixture\Builder
 *
 * @author  Carlo Tasca <ctasca@sessiondigital.com>
 */
class OauthConsumer extends AbstractBuilder
{
    /**
     *
     * Concrete classes to provide implementation for build method
     *
     * @return mixed
     */
    public function build()
    {
        return $this->_build();
    }
}