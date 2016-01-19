<?php

namespace Magefix\Fixture;

/**
 * Interface Typeable
 * @package Magefix\Fixture
 */
interface Typeable
{
    const SIMPLE_PRODUCT_FIXTURE_TYPE = 'Product';
    const CONFIGURABLE_PRODUCT_FIXTURE_TYPE = 'ConfigurableProduct';
    const BUNDLE_PRODUCT_FIXTURE_TYPE = 'BundleProduct';
    const GROUPED_PRODUCT_FIXTURE_TYPE = 'GroupedProduct';
    const SALES_ORDER_FIXTURE_TYPE = 'SalesOrder';
    const CATEGORY_FIXTURE_TYPE = 'Category';
    const CUSTOMER_FIXTURE_TYPE = 'Customer';
    const API_ROLE_FIXTURE_TYPE = 'ApiRole';
    const API_USER_FIXTURE_TYPE = 'ApiUser';
    const ADMIN_FIXTURE_TYPE = 'Admin';
}