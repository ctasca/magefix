<?php
namespace Magefix\Behat\Page\Element;

use SensioLabs\Behat\PageObjectExtension\PageObject\Element;

/**
 * Class Parameter
 * @package Magefix\Behat\Page\Element
 * @author  Carlo Tasca <ctasca.d3@gmail.com>
 */
abstract class Generic extends Element implements Parameterable
{
    /**
     * @var string
     */
    private $parameter = '';

    /**
     * @param $parameter
     */
    public function setParameter($parameter)
    {
        $this->parameter = $parameter;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function getXpath()
    {
        if (empty($this->parameter)) {
            throw new \Exception("Parameter not set for element Xpath");
        }

        $realXPath = str_replace('{parameter}', $this->parameter, $this->selector['xpath']);
        $this->selector = ['xpath' => $realXPath];

        return $realXPath;
    }
}
