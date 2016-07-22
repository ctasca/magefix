<?php
namespace Magefix\Fixture\Builder\Helper;

use Mage;
use Magefix\Fixture\Builder\Helper;

/**
 * Class ApiRole
 * @package Magefix\Fixture\Builder\Helper
 * @author  Carlo Tasca <ctasca.d3@gmail.com>
 */
class ApiRole implements Helper
{
    /**
     * @param array $data
     * @return mixed
     */
    public static function create(array $data)
    {
        $role = Mage::getModel('api/roles');

        $role = $role
            ->setName($data['name'])
            ->setPid($data['pid'])
            ->setRoleType($data['role_type'])
            ->save();

        Mage::getModel("api/rules")
            ->setRoleId($role->getId())
            ->setResources(["all"])
            ->saveRel();

        return $role->getId();
    }
}
