<?php

namespace Data\Providers;

use Mage_Catalog_Model_Product;
use Mage_Catalog_Model_Product_Visibility;
use Magefix\Fixtures\Data\Provider;
use Magefix\Fixture\Builder\Helper\EavAttribute;
use Magefix\Fixture\Builder\Helper\AttributeSet;
/**
 * Class ConfigurableSimpleProduct
 *
 * @package Data\Providers
 * @author  Carlo Tasca <ctasca@sessiondigital.com>
 */
class ConfigurableSimpleProduct extends SimpleProduct implements Provider
{
    public function getClothingAttributeSetId()
    {
        return AttributeSet::getIdByName('Clothing');
    }

    public function getBlackColorOptionId()
    {
        return EavAttribute::getOptionValueByLabel(Mage_Catalog_Model_Product::ENTITY, 'color', 'Black');
    }

    public function getBlueColorOptionId()
    {
        return EavAttribute::getOptionValueByLabel(Mage_Catalog_Model_Product::ENTITY, 'color', 'Blue');
    }

    public function getXLSizeOptionId()
    {
        return EavAttribute::getOptionValueByLabel(Mage_Catalog_Model_Product::ENTITY, 'size', 'XL');
    }

    public function getMSizeOptionId()
    {
        return EavAttribute::getOptionValueByLabel(Mage_Catalog_Model_Product::ENTITY, 'size', 'M');
    }

    public function getDenimOptionId()
    {
        return EavAttribute::getOptionValueByLabel(Mage_Catalog_Model_Product::ENTITY, 'apparel_type', 'Denim');
    }

    public function getFixtureImage()
    {
        return '/vagrant/features/fixtures/images/placeholder.jpg';
    }

    public function getVisibility()
    {
        return Mage_Catalog_Model_Product_Visibility::VISIBILITY_NOT_VISIBLE;
    }

    public function getAssociatedProductQty()
    {
        return 5;
    }
}
