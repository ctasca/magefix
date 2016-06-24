<?php

namespace Magefix\Behat\Page\Element;

/**
 * Interface Parameterable
 * @package Magefix\Behat\Page\Element
 */
interface Parameterable
{
    /**
     * @param $parameter
     */
    public function setParameter($parameter);

    /**
     * @return string
     */
    public function getXpath();
}
