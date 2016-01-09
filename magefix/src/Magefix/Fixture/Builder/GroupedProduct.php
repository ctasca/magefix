<?php

namespace Magefix\Fixture\Builder;

use Mage;
use Mage_Catalog_Model_Product_Type;

/**
 * Class GroupedProduct
 * @package Magefix\Fixture\Builder
 * @author  Carlo Tasca <ctasca@sessiondigital.com>
 */
class GroupedProduct extends Product
{
    private $_groupedProducts = [];
    private $_groupedProductsIds = [];

    public function build()
    {
        $mergedData = $this->_beforeBuild();
        $this->_buildGroupedSimpleProducts();
        $this->_getMageModel()->setData($mergedData);
        $fixtureId = $this->_saveFixture();
        $this->_linkSimpleProducts($fixtureId);

        return $fixtureId;
    }

    /**
     * @param int $groupedProductId
     */
    protected function _linkSimpleProducts($groupedProductId)
    {
        $this->_prepareProductIds();
        $productLinkApi = Mage::getModel('catalog/product_link_api');
        $iterator = new \ArrayIterator($this->_groupedProductsIds);
        while ($iterator->valid()) {
            $productLinkApi->assign (
                Mage_Catalog_Model_Product_Type::TYPE_GROUPED, $groupedProductId, $iterator->current()
            );
            $iterator->next();
        }
    }

    protected function _buildGroupedSimpleProducts()
    {
        $this->_groupedProducts = $this->_buildManySimple('grouped_products');
    }

    protected function _prepareProductIds()
    {
        $iterator = new \ArrayIterator($this->_groupedProducts);
        while ($iterator->valid()) {
            $current = $iterator->current();
            $this->_groupedProductsIds[] = $current->getId();
            $iterator->next();
        }
    }

}