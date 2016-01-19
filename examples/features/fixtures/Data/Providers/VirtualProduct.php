<?php

namespace Data\Providers;

use Mage_Catalog_Model_Product_Type;
use Mage_Catalog_Model_Product_Visibility;
use Magefix\Fixtures\Data\Provider;

/**
 * Class VirtualProduct
 *
 * @package Data\Providers
 * @author  Carlo Tasca <ctasca@sessiondigital.com>
 */
class VirtualProduct extends SimpleProduct implements Provider
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
        return [24];
    }

    public function getTypeId()
    {
        return Mage_Catalog_Model_Product_Type::TYPE_VIRTUAL;
    }
}
