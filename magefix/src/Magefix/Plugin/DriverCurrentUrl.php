<?php

namespace Magefix\Plugin;

/**
 * Class DriverCurrentUrl
 * 
 * @package Magefix\Plugin
 * @author  Carlo Tasca <ctasca@inviqa.com>
 */
trait DriverCurrentUrl
{
    abstract public function getDriver();

    /**
     * @return mixed
     */
    public function getDriverCurrentUrl()
    {
        return $this->getDriver()->getCurrentUrl();
    }
}
