<?php

namespace Magefix\Plugin;

use Behat\Mink\Driver\DriverInterface;

/**
 * Class WindowResizer
 * 
 * @package Magefix\Plugin
 * @author  Carlo Tasca <ctasca@inviqa.com>
 */
trait WindowResizer
{
    private $desktopWidth = 1920;
    private $desktopHeight = 1080;
    private $mobileWidth = 320;
    private $mobileHeight = 568;

    /**
     * Resize window to desktop size
     *
     * @param DriverInterface $driver
     */
    public function resizeToDesktopWindow(DriverInterface $driver)
    {
        $driver->resizeWindow($this->desktopWidth, $this->desktopHeight);
    }

    /**
     * Resize window to mobile size
     *
     * @param DriverInterface $driver
     */
    public function resizeToMobileWindow(DriverInterface $driver)
    {
        $driver->resizeWindow($this->desktopWidth, $this->desktopHeight);
    }
}
