<?php

namespace Magefix\Fixture\Builder;

use FixturesLocator;
use Mage;
use Magefix\Fixture\Builder\Helper\ApiUser as ApiUserHelper;

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
        $this->iterateFixture();

        $this->_throwUndefinedAttributesException(isset($this->_data['fixture']['api_role']['model']),
            'Api Role model has not been defined. Check fixture yml.');
        $roleModel = Mage::getModel($this->_data['fixture']['api_role']['model']);
        $roleBuilderData['fixture'] = $this->_data['fixture']['api_role'];
        $role =  new ApiRole($roleBuilderData, $roleModel, $this->_getHook());
        $roleId = $role->build();

        $fixtureId = ApiUserHelper::create($this->_getMageModel(), $roleId, $this->_data['fixture']['attributes']);

        return $fixtureId;
    }
}