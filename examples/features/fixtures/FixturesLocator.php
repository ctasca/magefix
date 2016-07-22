<?php

use Magefix\Parser\ResourceLocator;

/**
 * Class FixturesLocator
 *
 * @author Carlo Tasca <ctasca.d3@gmail.com>
 */
class FixturesLocator implements ResourceLocator
{
    public function getLocation()
    {
        return 'features/fixtures/yaml/';
    }
}
