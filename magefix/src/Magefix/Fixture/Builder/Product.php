<?php

namespace Magefix\Fixture\Builder;

use Magefix\Fixture\Builder\Helper\MediaGalleryImage;
use Magefix\Magento\Store\Scope as MagentoStoreScope;
use Magefix\Exceptions\UndefinedStockData;

/**
 * Class Product
 *
 * @package Magefix\Fixture\Builder
 * @author  Carlo Tasca <ctasca.d3@gmail.com>
 */
class Product extends AbstractBuilder
{
    /**
     * @return int
     * @throws \Exception
     *
     */
    public function build()
    {
        $mergedData = $this->_beforeBuild();
        $fixtureId = $this->_saveFixtureWithModelAndData($this->_getMageModel(), $mergedData);

        $this->_addMediaGalleryImage($fixtureId);

        return $fixtureId;
    }

    /**
     * @param $fixtureId
     */
    public function addMediaGalleryImage($fixtureId)
    {
        $this->_addMediaGalleryImage($fixtureId);
    }

    /**
     * @param $fixtureYml
     *
     * @return mixed
     */
    public function getFixtureStockData($fixtureYml)
    {
        return $this->_getFixtureStockData($fixtureYml);
    }

    /**
     * @param $fixtureId
     * @param bool $save
     * @throws \Magefix\Exceptions\ProductMediaGalleryImageNotFound
     */
    protected function _addMediaGalleryImage($fixtureId, $save = true)
    {
        if ($this->_hasMediaGallery()) {
            MagentoStoreScope::setAdminStoreScope();
            $product = $this->_getMageModel()->load($fixtureId);

            if ($product) {
                MediaGalleryImage::save($product, $this->_getMediaGallery(), $save);
            }

            MagentoStoreScope::setCurrentStoreScope();
        }
    }

    /**
     * @param $fixtureYml
     *
     * @return mixed
     * @throws UndefinedStockData exception
     */
    protected function _getFixtureStockData($fixtureYml)
    {
        $this->_throwUndefinedStockData($fixtureYml);

        return $fixtureYml['stock']['stock_data'];
    }

    /**
     * @return bool
     */
    protected function _hasMediaGallery()
    {
        $hasMediaGallery = false;

        if (isset($this->_data['fixture']['media']['gallery'])
            && isset($this->_data['fixture']['media']['gallery']['image'])
        ) {
            $hasMediaGallery = true;
        }

        return $hasMediaGallery;
    }

    /**
     * @return array
     */
    protected function _getMediaGallery()
    {
        return $this->_data['fixture']['media']['gallery'];
    }

    /**
     * @param array $fixtureYml
     *
     * @throws UndefinedStockData
     */
    protected function _throwUndefinedStockData(array $fixtureYml)
    {
        if (!isset($fixtureYml['stock']['stock_data'])) {
            throw new UndefinedStockData(
                'Fixture stock data have not been defined. Check fixture yml file.'
            );
        }
    }

    /**
     * @return array
     * @throws \Magefix\Exceptions\UndefinedAttributes
     *
     */
    protected function _beforeBuild()
    {
        $this->invokeProvidersMethods();
        $fixtureStockData = [];
        $defaultData = $this->_getMageModelData() ? $this->_getMageModelData() : [];
        $fixtureData = $this->_getFixtureAttributes();
        $fixtureStockData['stock_data'] = $this->getFixtureStockData($this->_data['fixture']);

        $mergedData = array_merge($defaultData, $fixtureData, $fixtureStockData);

        return $mergedData;
    }
}
