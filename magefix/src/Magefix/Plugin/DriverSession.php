<?php

namespace Magefix\Plugin;

use Behat\Mink\Driver\Selenium2Driver;

/**
 * Class DriverSession
 * 
 * @package Magefix\Plugin
 * @author  Carlo Tasca <ctasca@inviqa.com>
 */
trait DriverSession
{
    abstract public function getDriver();

    /**
     * Refresh driver session
     */
    public function refreshSelenium2Session()
    {
        $driver = $this->getDriver();

        if ($driver instanceof Selenium2Driver) {
            $session = $driver->getWebDriverSession();
            $session->refresh();
        }
    }
}
