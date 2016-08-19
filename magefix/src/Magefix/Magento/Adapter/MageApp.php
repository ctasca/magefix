<?php

namespace Magefix\Magento\Adapter;

use Mage;
/**
 * Class MageApp
 * @package Magefix\Magento\Adapter
 * @author  Carlo Tasca <ctasca.d3@gmail.com>
 */
class MageApp
{
    /**
     * Loads Magento app in adapters
     *
     * Solves PHP Fatal error such as:
     *
     * Call to a member function getModelInstance() on a non-object in /vagrant/public/app/Mage.php on line 463
     * when used in testing frameworks, e.g. PHPSpec
     *
     * @return \Mage_Core_Model_App
     */
    public static function get()
    {
        return Mage::app();
    }

    /**
     * Initiate Mage::app() in Adapters
     */
    public static function init()
    {
        Mage::app();
    }
}
