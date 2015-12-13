<?php

namespace Data\Providers;

use Mage_Catalog_Model_Product_Type;
use Mage_Catalog_Model_Product_Visibility;
use Magefix\Fixtures\Data\Provider;

/**
 * Class SimpleProduct
 *
 * @package Data\Providers
 * @author  Carlo Tasca <ctasca@sessiondigital.com>
 */
class SimpleProduct implements Provider
{
    public function getWebsiteIds()
    {
        return [1];
    }

    public function getDefaultAttributeSetId()
    {
        return 4;
    }

    public function getCategoryIds()
    {
        return [5, 14];
    }

    public function getSku()
    {
        $random = substr(md5(rand()), 0, 7);

        return 'SKU-' . $random;
    }

    public function getTypeId()
    {
        return Mage_Catalog_Model_Product_Type::TYPE_SIMPLE;
    }

    public function getStockQty()
    {
        return 10;
    }

    public function getFixtureImage()
    {
        return '/vagrant/features/fixtures/images/placeholder.jpg';
    }

    public function getVisibility()
    {
        return Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH;
    }
}
