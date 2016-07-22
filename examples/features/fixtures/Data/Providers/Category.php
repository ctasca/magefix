<?php

namespace Data\Providers;

use Mage;
use Magefix\Fixtures\Data\Provider;

/**
 * Class Category
 *
 * @package Data\Providers
 * @author  Carlo Tasca <ctasca.d3@gmail.com>
 */
class Category implements Provider
{
    public function getParentId()
    {
        return Mage::app()->getStore('default')->getRootCategoryId();
    }

    public function getStoreId()
    {
        return Mage::app()->getStore('default')->getId();
    }
}
