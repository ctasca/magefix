<?php

namespace Magefix\Fixture\Builder;

use Magefix\Exceptions\UndefinedBundleOptions;
use Magefix\Exceptions\UndefinedBundleProducts;
use Magefix\Exceptions\UndefinedFixtureModel;
use Mage;
use Magefix\Magento\Store\Scope as MagentoStoreScope;

/**
 * Class BundleProduct
 *
 * @package Magefix\Fixture\Builder
 * @author  Carlo Tasca <ctasca@sessiondigital.com>
 */
class BundleProduct extends Product
{
    /**
     * @var array
     */
    private $_bundleOptions = [];

    /**
     * @var array
     */
    private $_bundleSelections = [];

    /**
     * @var array
     */
    private $_bundleProducts = [];

    public function build()
    {
        $mergedData = $this->_beforeBuild();

        $this->_getMageModel()->setData($mergedData);

        $fixtureId = $this->_saveFixture();

        return $fixtureId;
    }

    /**
     *
     * @return mixed
     * @throws ProductMediaGalleryImageNotFound
     *
     */
    protected function _saveFixture()
    {
        MagentoStoreScope::setAdminStoreScope();
        $this->_getMageModel()->setCanSaveCustomOptions(true);
        $this->_getMageModel()->setCanSaveBundleSelections(true);
        $this->_getMageModel()->setAffectBundleProductSelections(true);
        Mage::register('product', $this->_getMageModel());
        $this->_buildBundleProductsFixtures();
        $this->_setBundleOptions();
        $this->_getMageModel()->setBundleOptionsData($this->_bundleOptions);
        $this->_setBundleSelections();
        $this->_getMageModel()->setBundleSelectionsData($this->_bundleSelections);
        $this->_addMediaGalleryImage($this->_getMageModel()->getId(), false);
        $fixture = $this->_getMageModel()->save();
        MagentoStoreScope::setCurrentStoreScope();

        return $fixture->getId();
    }

    /**
     * @throws UndefinedAssociatedProducts
     * @throws UndefinedFixtureModel
     * @throws ProductMediaGalleryImageNotFound
     * @throws UnavailableHook
     *
     */
    protected function _buildBundleProductsFixtures()
    {
        $this->_throwUndefinedBundleProducts();
        $this->_bundleProducts = $this->_buildManySimple('bundle_products');
    }

    /**
     * @throws UndefinedBundleOptions
     *
     */
    protected function _setBundleOptions()
    {
        $this->_throwUndefinedBundleOptions();
        $this->_bundleOptions = $this->_data['fixture']['bundle_options'];

    }

    /**
     * @throws UndefinedBundleSelections
     *
     */
    protected function _setBundleSelections()
    {
        $this->_throwUndefinedBundleSelections();
        $this->_bundleSelections = $this->_data['fixture']['bundle_selections'];

        foreach ($this->_bundleSelections as &$selections) {
            foreach ($selections as &$selection) {
                if (isset($selection['product_id'])) {
                    $productId = trim($selection['product_id'], '#');
                    if (is_numeric($productId) && isset($this->_bundleProducts[$productId])) {
                        $selection['product_id'] = $this->_bundleProducts[$productId]->getId();
                    }
                }
            }
        }
    }

    /**
     * @throws UndefinedBundleProducts
     */
    protected function _throwUndefinedBundleProducts()
    {
        if (!isset($this->_data['fixture']['bundle_products']['products'])) {
            throw new UndefinedBundleProducts(
                'Bundle Product Fixture: Bundle products have not been defined. Check fixture yaml.'
            );
        }
    }

    /**
     * @throws UndefinedBundleOptions
     */
    protected function _throwUndefinedBundleOptions()
    {
        if (!isset($this->_data['fixture']['bundle_options'])) {
            throw new UndefinedBundleOptions(
                'Bundle Product Fixture: Bundle options have not been defined. Check fixture yaml.'
            );
        }
    }

    /**
     * @throws UndefinedBundleOptions
     */
    protected function _throwUndefinedBundleSelections()
    {
        if (!isset($this->_data['fixture']['bundle_selections'])) {
            throw new UndefinedBundleSelections(
                'Bundle Product Fixture: Bundle selections have not been defined. Check fixture yaml.'
            );
        }
    }
}
