<?php

namespace Magefix\Fixture\Builder;

use Mage;
use Magefix\Exceptions\UndefinedAttributes;

/**
 * Class Admin
 *
 * @package Magefix\Fixture\Builder
 * @author  Daniel Kidanemariam <danielk@sessiondigital.com>
 */
class Admin extends AbstractBuilder
{
    /**
     * @return int
     * @throws \Exception
     *
     */
    public function build()
    {
        $this->iterateFixture();
        $defaultData = $this->_getMageModelData() ? $this->_getMageModelData() : [];
        $mergedData = array_merge($defaultData, $this->_getFixtureAttributes());

        $this->_getMageModel()->setData($mergedData);

        return $this->_saveFixture();
    }
}
