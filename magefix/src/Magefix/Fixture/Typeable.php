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
    const SALES_ORDER_FIXTURE_TYPE = 'SalesOrder';
    const CATEGORY_FIXTURE_TYPE = 'Category';
    const CUSTOMER_FIXTURE_TYPE = 'Customer';
    const API_USER_FIXTURE_TYPE = 'ApiUser';
}