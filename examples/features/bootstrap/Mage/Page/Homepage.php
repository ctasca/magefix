<?php

namespace Mage\Page;

use Magefix\Behat\Page\MagePage;

/**
 * Class Homepage
 * @package Mage\Page
 * @author  Carlo Tasca <ctasca.d3@gmail.com>
 */
class Homepage extends MagePage
{
    protected $path = '/';

    public function getHeaderElement()
    {
        return $this->getElementObject("Frontend\\Header");
    }
}
