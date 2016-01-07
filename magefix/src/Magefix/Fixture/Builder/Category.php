<?php

namespace Magefix\Fixture\Builder;

use Magefix\Exceptions\NullCategoryParentId;

/**
 * Class Category
 *
 * @package Magefix\Fixture\Builder
 * @author  Carlo Tasca <ctasca@sessiondigital.com>
 */
class Category extends AbstractBuilder
{
    public function build()
    {
        $this->iterateFixture();
        $fixtureData = $this->_getFixtureAttributes();

        if (!isset($fixtureData['parent_id'])) {
            throw new NullCategoryParentId('Category fixture require parent_id. Check fixture yaml file.');
        }

        $parentCategory     = $this->_getMageModel()->load((int) $fixtureData['parent_id']);
        $parentCategoryPath = $parentCategory->getPath();
        unset($fixtureData['parent_id']);
        $fixture = $this->_getMageModel()->setData($fixtureData);
        $fixture->setPath($parentCategoryPath);

        return $this->_saveFixture();
    }
}
