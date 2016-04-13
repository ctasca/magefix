<?php

namespace Magefix\Plugin;

use Behat\Mink\Element\NodeElement;

/**
 * Class ElementObjectGetter
 *
 * Provide functionality to create an Element object without throwing an
 * Exception when xpath cannot be found and need the instance of the element.
 *
 * Allows for dynamic xpath selectors in Element instances.
 *
 * @package Magefix\Plugin
 * @author  Carlo Tasca <ctasca@inviqa.com>
 */
trait ElementObjectGetter
{
    /**
     * @param $name
     * @return mixed
     */
    public abstract function createElement($name);

    /**
     * @param string $name
     *
     * @return NodeElement
     */
    public function getElementObject($name)
    {
        return $this->createElement($name);
    }
}
