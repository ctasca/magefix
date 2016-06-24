<?php

namespace Magefix\Behat\Page\Element;

/**
 * Class XpathId
 * @package Magefix\Behat\Page\Element
 * @author  Carlo Tasca <ctasca@inviqa.com>
 */
class XpathId extends Parameter
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
