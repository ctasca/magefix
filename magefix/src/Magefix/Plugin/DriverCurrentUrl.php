<?php

namespace Magefix\Plugin;

/**
 * Class DriverCurrentUrl
 * 
 * @package Magefix\Plugin
 * @author  Carlo Tasca <ctasca.d3@gmail.com>
 */
trait DriverCurrentUrl
{
    abstract public function getDriver();

    /**
     * Magefix version backward compatibility method before refactoring to getDriverCurrentUrl
     *
     *
     * @return mixed
     */
    public function getCurrentUrl()
    {
        return $this->getDriverCurrentUrl();
    }

    /**
     * @return mixed
     */
    public function getDriverCurrentUrl()
    {
        return $this->getDriver()->getCurrentUrl();
    }
}
