<?php

use Mage\Page\Homepage;

class HomepageContext implements \Behat\Behat\Context\Context
{

    public function __construct(Homepage $homepage)
    {
        $this->_homepage = $homepage;
    }

    /**
     * @Given I am on the homepage
     */
    public function iAmOnTheHomepage()
    {
        $this->_homepage->open();
    }

    /**
     * @Then I want to get an element by id without creating the element object
     * @Then I want to get an element by xpath id without creating the element object
     */
    public function iWantToGetAnElementByIdWithoutCreatingTheElementObject()
    {
        $xpathElement = $this->_homepage->getHeaderElement();
        $xpathElement->setParameter('header');
        $xpathElement->click();

    }
}
