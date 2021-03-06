<?php
namespace Magefix\Plugin;

use SensioLabs\Behat\PageObjectExtension\PageObject\Element;

/**
 * Class DriverSwitcher
 * @package Magefix\Plugin
 * @author  Carlo Tasca <ctasca.d3@gmail.com>
 */
trait DriverSwitcher
{
    public abstract function getElementObject($element);

    public abstract function getDriver();

    /**
     * @param string | Element $iFrameElement
     * @throws \ReflectionException
     */
    public function switchToIFrame($iFrameElement)
    {
        $iFrame = null;

        if (is_string($iFrameElement)) {
            $iFrame = $this->getElementObject($iFrameElement);
        }

        if (is_object($iFrameElement)) {
            $iFrame = $iFrameElement;
        }

        $this->switchToIFrameByCssId($iFrame);
    }

    /**
     * @param null|string $name
     */
    public function switchToWindow($name = null)
    {
        $this->getDriver()->switchToWindow($name);
    }

    /**
     * Return the name of the currently active window.
     *
     * @return string the name of the current window
     */
    public function getDriverActiveWindowName()
    {
        return $this->getDriver()->getWindowName();
    }

    /**
     * @param $iFrame
     * @throws \ReflectionException
     */
    private function switchToIFrameByCssId($iFrame)
    {
        if ($iFrame instanceof Element) {
            $reflectedElement = new \ReflectionClass($iFrame);
            if ($reflectedElement->hasMethod('getCssId') === false) {
                throw new \ReflectionException("getCssId method not in Element " . get_class($iFrame));
            }
            $iFrameId = $iFrame->getCssId();
            $this->getDriver()->switchToIFrame($iFrameId);
        }
    }
}
