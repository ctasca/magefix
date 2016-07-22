<?php

namespace Magefix\Behat\Page\Element;

/**
 * Class XPathIdSelectorElement
 * @package Magefix\Behat\Page\Element
 * @author  Carlo Tasca <ctasca@inviqa.com>
 */
class XPathIdSelectorElement extends Parameter
{
    /**
     * @var array
     */
    protected $selector = ['xpath' => '//*[@id="{parameter}"]'];

    /**
     * setParameter wrapper
     * 
     * @param $id
     */
    public function setId($id) 
    {
        $this->setParameter($id);
    }
}