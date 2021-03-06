<?php

namespace Magefix\Magento\Model;

use Magefix\Exceptions\UnmappableType;
use Magefix\Fixture\Factory\Builder;

/**
 * Class Mapper
 * @package Magefix\Magento\Model
 */
class Mapper
{
    /**
     * @var array
     */
    private static $_map = [
        Builder::SIMPLE_PRODUCT_FIXTURE_TYPE => 'catalog/product',
        Builder::CONFIGURABLE_PRODUCT_FIXTURE_TYPE => 'catalog/product',
        Builder::BUNDLE_PRODUCT_FIXTURE_TYPE => 'catalog/product',
        Builder::GROUPED_PRODUCT_FIXTURE_TYPE => 'catalog/product',
        Builder::CATEGORY_FIXTURE_TYPE => 'catalog/category',
        Builder::CUSTOMER_FIXTURE_TYPE => 'customer/customer',
        Builder::SALES_ORDER_FIXTURE_TYPE => 'sales/order',
        Builder::API_ROLE_FIXTURE_TYPE => 'api/roles',
        Builder::API_USER_FIXTURE_TYPE => 'api/user',
        Builder::ADMIN_FIXTURE_TYPE => 'admin/user',
        Builder::OAUTH_CONSUMER_FIXTURE_TYPE => 'oauth/consumer',
    ];

    public static function getMap()
    {
        return self::$_map;
    }

    /**
     * @param $fixtureType
     * @return mixed
     * @throws UnmappableType
     */
    public static function map($fixtureType)
    {
        if (!isset(self::$_map[$fixtureType])) {
            throw new UnmappableType("Fixture type '{$fixtureType}' could not be mapped to any Magento model");
        }

        return self::$_map[$fixtureType];
    }
}