<?php

namespace Magefix\Fixture\Builder\Helper;

use Mage_Api_Model_User;
use Magefix\Fixture\Builder\Helper;

/**
 * Class ApiUser
 * @package Magefix\Fixture\Builder\Helper
 * @author  Carlo Tasca <ctasca.d3@gmail.com>
 */
class ApiUser implements Helper
{
    /**
     * @param Mage_Api_Model_User $userModel
     * @param $roleId
     * @param array $data
     * @return Mage_Api_Model_User|\Mage_Core_Model_Abstract
     */
    public static function create(Mage_Api_Model_User $userModel, $roleId, array $data)
    {
        $data['roles'] = [$roleId];
        $userModel->setData($data);
        $userModel->save();
        self::saveRelations($userModel, $roleId);

        return $userModel->getId();
    }

    private static function saveRelations(Mage_Api_Model_User $userModel, $roleId)
    {
        $userModel->setRoleIds([$roleId])
            ->setUserId($userModel->getId())
            ->saveRelations();
    }
}
