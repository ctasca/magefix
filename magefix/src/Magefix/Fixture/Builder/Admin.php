<?php

namespace Magefix\Fixture\Builder;

/**
 * Class Admin
 *
 * @package Magefix\Fixture\Builder
 * @author  Daniel Kidanemariam <danielk@sessiondigital.com>
 */
class Admin extends AbstractBuilder
{
    /**
     * @return int
     * @throws \Exception
     *
     */
    public function build()
    {
        $fixtureId = $this->_build();
        $this->_assignRoleIds();
        return $fixtureId;
    }

    protected function _assignRoleIds()
    {
        if (isset($this->_data['fixture']['attributes']['roles_ids'])) {
            $adminUser = $this->_getMageModel();
            $adminUser->setRoleIds($this->_data['fixture']['attributes']['roles_ids'])
                ->setRoleUserId($adminUser->getId())
                ->saveRelations();
        }
    }
}
