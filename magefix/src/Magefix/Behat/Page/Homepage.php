<?php

namespace Magefix\Behat\Page;

use SensioLabs\Behat\PageObjectExtension\PageObject\Page as PageObject;
use Magefix\Plugin\WindowResizer;
use Magefix\Plugin\StorePage;
use Magefix\Plugin\DriverCurrentUrl;

/**
 * Class Homepage
 * @package Magefix\Behat\Page
 * @author  Carlo Tasca <ctasca@inviqa.com>
 */
class Homepage extends PageObject
{
    use StorePage;
    use WindowResizer;
    use DriverCurrentUrl;

    protected $path = '/';
}
