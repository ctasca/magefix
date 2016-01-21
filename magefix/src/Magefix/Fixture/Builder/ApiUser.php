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
class ApiUser extends AbstractBuilder
{
    /**
     *
     * Concrete classes to provide implementation for build method
     *
     * @return mixed
     */
    public function build()
    {
        $this->invokeProvidersMethods();

        $this->_throwUndefinedAttributesException(isset($this->_data['fixture']['api_role']['model']),
            'Api Role model has not been defined. Check fixture yml.');
        $roleId = $this->_buildApiRoleFixture();

        $fixtureId = ApiUserHelper::create($this->_getMageModel(), $roleId, $this->_data['fixture']['attributes']);

        return $fixtureId;
    }

    /**
     * @return mixed
     */
    protected function _buildApiRoleFixture()
    {
        $roleBuilderData = [];
        $roleBuilderData['fixture'] = $this->_data['fixture']['api_role'];
        $fixture = Instanciator::instance(Builder::API_ROLE_FIXTURE_TYPE, $roleBuilderData, $this->_getHook());
        $roleId = $fixture->buildAndRegister();
        return $roleId;
    }
}