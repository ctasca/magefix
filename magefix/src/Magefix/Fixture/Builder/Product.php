<?php

namespace Magefix\Fixture\Builder;

use Mage_Core_Model_Abstract;
use Magefix\Magento\Store\Scope as MagentoStoreScope;
use Magefix\Exceptions\UndefinedStockData;
use Magefix\Exceptions\ProductMediaGalleryImageNotFound;

/**
 * Class Product
 *
 * @package Magefix\Fixture\Builder
 * @author  Carlo Tasca <ctasca@sessiondigital.com>
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
        $fixtureId  = $this->_saveFixtureWithModelAndData($this->_getMageModel(), $mergedData);

        $this->_addMediaGalleryImage($fixtureId);

        return $fixtureId;
    }

    /**
     * @param $fixtureId
     *
     * @throws ProductMediaGalleryImageNotFound
     *
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
     * @param      $fixtureId
     * @param bool $save
     *
     * @throws ProductMediaGalleryImageNotFound exception
     * @throws \Exception
     */
    protected function _addMediaGalleryImage($fixtureId, $save = true)
    {
        if ($this->_hasMediaGallery()) {
            MagentoStoreScope::setAdminStoreScope();
            $product = $this->_getMageModel()->load($fixtureId);

            if ($product) {
                $gallery = $this->_processFixtureAttributes($this->_getMediaGallery());

                if (!@file_exists($gallery['image'])) {
                    throw new ProductMediaGalleryImageNotFound(
                        'Specified product fixture gallery image does not exists -> ' . $gallery['image']
                    );
                }

                $product->addImageToMediaGallery(
                    $gallery['image'], ['image', 'thumbnail', 'small_image'], false, false
                );

                if ($save) {
                    $product->save();
                }
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

        return $this->_processFixtureAttributes($fixtureYml['stock']['stock_data']);
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
        $fixtureStockData = [];
        $defaultData = $this->_getMageModelData() ? $this->_getMageModelData() : [];
        $fixtureData = $this->_getFixtureAttributes();
        $fixtureStockData['stock_data'] = $this->getFixtureStockData($this->_data['fixture']);

        $mergedData = array_merge($defaultData, $fixtureData, $fixtureStockData);

        return $mergedData;
    }
}
