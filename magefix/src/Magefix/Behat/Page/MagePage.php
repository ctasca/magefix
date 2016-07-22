<?php

namespace Magefix\Behat\Page;

use SensioLabs\Behat\PageObjectExtension\PageObject\Page as PageObject;

use Magefix\Plugin\AdminPanelSession;
use Magefix\Plugin\DriverCurrentUrl;
use Magefix\Plugin\DriverSession;
use Magefix\Plugin\DriverSwitcher;
use Magefix\Plugin\ElementObjectGetter;
use Magefix\Plugin\Spinner;
use Magefix\Plugin\StorePage;
use Magefix\Plugin\WindowResizer;

/**
 * Class MagePage
 *
 * Provides a generic class to instantiate Behat Page Objects with Magefix Plugins
 *
 * @package Magefix\Behat\Page
 * @author  Carlo Tasca <ctasca.d3@gmail.com>
 */
abstract class MagePage extends PageObject
{
    use AdminPanelSession;
    use DriverCurrentUrl;
    use DriverSwitcher;
    use DriverSession;
    use ElementObjectGetter;
    use Spinner;
    use StorePage;
    use WindowResizer;
}
