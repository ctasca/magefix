<?php

namespace Magefix\Fixture\Builder;

use \Magefix\Fixture\Builder\Helper\ApiRole as ApiRoleHelper;
use Magefix\Fixture\Factory\Builder;

/**
 * Class ApiRole
 * @package Magefix\Fixture\Builder
 * @author  Carlo Tasca <ctasca@sessiondigital.com>
 */
class ApiRole extends AbstractBuilder
{
    /**
     * @return mixed
     */
    public function build()
    {
        $this->invokeProvidersMethods();

        $fixtureId = ApiRoleHelper::create($this->_data['fixture']['attributes']);

        return $fixtureId;
    }

    /**
     * @return mixed
     */
    public function buildAndRegister()
    {
        $this->invokeProvidersMethods();

        $fixtureId = ApiRoleHelper::create($this->_data['fixture']['attributes']);
        Builder::registerFixture(Builder::API_ROLE_FIXTURE_TYPE, $fixtureId, $this->_getHook());

        return $fixtureId;
    }

}