<?php

use Magefix\Parser\ResourceLocator;

/**
 * Class FixturesLocator
 *
 * @author Carlo Tasca <ctasca@sessiondigital.com>
 */
class FixturesLocator implements ResourceLocator
{
    public function getLocation()
    {
        return 'features/fixtures/yaml/';
    }
}
