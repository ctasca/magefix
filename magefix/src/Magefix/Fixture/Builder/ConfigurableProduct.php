<?php

namespace Magefix\Fixture\Builder;

use Magefix\Exceptions\UndefinedAssociatedProducts;
use Magefix\Exceptions\UndefinedFixtureModel;
use Magefix\Exceptions\UndefinedUsedProductAttributeIds;
use Magefix\Fixture\Builder\Helper\EavAttribute;
use Mage_Catalog_Model_Product;

/**
 * Class ConfigurableProduct
 *
 * @package Magefix\Fixture\Builder
 * @author  Carlo Tasca <ctasca@sessiondigital.com>
 */
class ConfigurableProduct extends Product
{
    /**
     * @var array
     */
    private $_associatedProducts = [];

    /**
     * @var array
     */
    private $_usedProductAttributeIdsMap = [];

    /**
     * @var array
     */
    private $_usedProductAttributeIds = [];

    public function build()
    {
        $mergedData = $this->_beforeBuild();
        $this->_buildAssociatedProductFixtures();
        $this->_feedUsedProductAttributeIds();

        $this->_initFixtureWithData($mergedData);
        $this->_setConfigurableFixtureDataBeforeSave();

        $fixtureId = $this->_saveFixture();

        return $fixtureId;
    }

    /**
     * @throws UndefinedAssociatedProducts
     * @throws UndefinedFixtureModel
     * @throws ProductMediaGalleryImageNotFound
     * @throws UnavailableHook
     *
     */
    protected function _buildAssociatedProductFixtures()
    {
        $this->_throwUndefinedAssociatedProducts();
        $this->_associatedProducts = $this->_buildManySimple('associated_products');
    }

    /**
     * @return array
     * @throws UndefinedUsedProductAttributeIds
     *
     */
    protected function _feedUsedProductAttributeIds()
    {
        $this->_throwUndefinedUsedProductAttributeIds();

        foreach ($this->_data['fixture']['used_product_attributes'] as $usedAttributeCode) {
            $id = EavAttribute::getIdByCode(
                Mage_Catalog_Model_Product::ENTITY, $usedAttributeCode
            );
            $this->_usedProductAttributeIdsMap[$usedAttributeCode] = $id;
            $this->_usedProductAttributeIds[] = $id;
        }
    }

    /**
     * @return array
     *
     */
    protected function _prepareConfigurableProductsData()
    {
        $configurableData = [];

        foreach ($this->_associatedProducts as $product) {
            $configurableData[$product->getId()] = [];
            foreach ($this->_usedProductAttributeIdsMap as $code => $usedProductAttributeId) {
                array_push(
                    $configurableData[$product->getId()],
                    [
                        'attribute_id' => $usedProductAttributeId,
                        'label' => $product->getAttributeText($code),
                        'value_index' => (int) $product->getData($code),
                        'is_percent' => 0,
                        'pricing_value' => $product->getPrice(),
                        'simple_product_id' => $product->getId()
                    ]
                );
            }
        }

        return $configurableData;
    }

    /**
     * @throws ProductMediaGalleryImageNotFound
     *
     */
    protected function _setConfigurableFixtureDataBeforeSave()
    {
        $configurableFixture = $this->_getMageModel();

        $configurableFixture->setCanSaveConfigurableAttributes(true);
        $configurableFixture->setCanSaveCustomOptions(true);
        $configurableFixture->getTypeInstance()->setUsedProductAttributeIds($this->_usedProductAttributeIds);

        $attributesData = $configurableFixture->getTypeInstance()->getConfigurableAttributesAsArray();
        $configurableFixture->setConfigurableAttributesData($attributesData);

        $configurableProductsData = $this->_prepareConfigurableProductsData();
        $configurableFixture->setConfigurableProductsData($configurableProductsData);
        $this->_addMediaGalleryImage($configurableFixture->getId(), false);
    }

    /**
     * @throws UndefinedAssociatedProducts
     */
    protected function _throwUndefinedAssociatedProducts()
    {
        if (!isset($this->_data['fixture']['associated_products']['products'])) {
            throw new UndefinedAssociatedProducts(
                'Configurable Product Fixture: Associated products have not been defined. Check fixture yaml.'
            );
        }
    }

    /**
     * @throws UndefinedUsedProductAttributeIds
     *
     */
    protected function _throwUndefinedUsedProductAttributeIds()
    {
        if (!isset($this->_data['fixture']['used_product_attributes'])) {
            throw new UndefinedUsedProductAttributeIds(
                'Used product attributes have not been defined. Check fixture yaml.'
            );
        }
    }
}
