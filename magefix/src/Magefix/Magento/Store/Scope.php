<?php

namespace Magefix\Magento\Store;

use Mage;
use Mage_Core_Model_App;

/**
 * Class Scope
 *
 * Provides functionality to switch Magento store scope during fixtures building
 *
 * @package Magefix\Magento\Store
 * @author  Carlo Tasca <ctasca@sessiondigital.com>
 */
class Scope
{
    private static $_currentStore;

    /**
     * Register current store id and switch to admin store scope
     */
    public static function setAdminStoreScope()
    {
        self::$_currentStore = Mage::app()->getStore()->getId();
        Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
    }

    /**
     * Switch to current store scope
     */
    public static function setCurrentStoreScope()
    {
        Mage::app()->setCurrentStore(self::$_currentStore);
    }

    /**
     * @param $storeCode
     * @throws \Exception
     */
    public static function switchScope($storeCode)
    {
        $stores = Mage::getModel('core/store')->getCollection()
            ->addFieldToFilter('code', ['eq' => $storeCode]);

        $store = $stores->getSelect()->limit(1)->query()->fetch();

        if (empty($store)) {
            throw new \Exception("Unavailable data for store code: '{$storeCode}'");
        }

        Mage::app()->setCurrentStore($store['store_id']);
    }
}
