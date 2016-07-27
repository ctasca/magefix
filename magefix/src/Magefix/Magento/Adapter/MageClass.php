<?php

namespace Magefix\Magento\Adapter;
use Exception;
use Mage;
/**
 * Class MageClass
 * @package Magefix\Magento\Adapter
 * @author  Carlo Tasca <ctasca.d3@gmail.com>
 */
class MageClass implements Mageable
{
    public function __construct()
    {
        MageApp::init();
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return Mage::getVersion();
    }

    /**
     * @return array
     */
    public function getVersionInfo()
    {
        return Mage::getVersionInfo();
    }

    /**
     * @return string
     */
    public function getEdition()
    {
        return Mage::getEdition();
    }

    /**
     * @param $key
     * @param $value
     * @param bool $graceful
     */
    public function register($key, $value, $graceful = false)
    {
        Mage::register($key, $value, $graceful);
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function registry($key)
    {
        return Mage::registry($key);
    }

    /**
     * @param string $key
     */
    public function unregister($key)
    {
        Mage::unregister($key);
    }

    /**
     * @param string $type
     * @return string
     */
    public function getBaseDir($type = 'base')
    {
        return Mage::getBaseDir($type);
    }


    /**
     *  Parameter type can be:
     * - etc
     * - controllers
     * - sql
     * - data
     * - locale
     * @param $type
     * @param $moduleName
     * @return string
     */
    public function getModuleDir($type, $moduleName)
    {
        return Mage::getModuleDir($type, $moduleName);
    }

    /**
     * @param $path
     * @param null $store
     * @return mixed
     */
    public function getStoreConfig($path, $store = null)
    {
        return Mage::getStoreConfig($path, $store);
    }

    /**
     * @param $path
     * @param null $store
     * @return bool
     */
    public function getStoreConfigFlag($path, $store = null)
    {
        return Mage::getStoreConfigFlag($path, $store);
    }

    /**
     * @return \Mage_Core_Model_Config
     */
    public function getConfig()
    {
        return Mage::getConfig();
    }

    /**
     * @return \Varien_Event_Collection
     */
    public function getEvents()
    {
        return Mage::getEvents();
    }

    /**
     * @param $name
     * @return \Mage_Core_Helper_Abstract
     */
    public function helper($name)
    {
        return Mage::helper($name);
    }

    /**
     * @param string $modelClass
     * @param array $arguments
     * @return false|\Mage_Core_Model_Abstract
     */
    public function getModel($modelClass = '', $arguments = array())
    {
        return Mage::getModel($modelClass, $arguments);
    }

    /**
     * Set all my data to defaults
     *
     */
    public function reset()
    {
        Mage::reset();
    }

    /**
     * Set application root absolute path
     *
     * @param string $appRoot
     * @throws Mage_Core_Exception
     */
    public function setRoot($appRoot = '')
    {
        Mage::setRoot($appRoot);
    }

    /**
     * Retrieve application root absolute path
     *
     * @return string
     */
    public function getRoot()
    {
        return Mage::root();
    }

    /**
     * Varien Objects Cache
     *
     * @param string $key optional, if specified will load this key
     * @return Varien_Object_Cache
     */
    public function objects($key = null)
    {
        // TODO: Implement objects() method.
    }

    /**
     * Get base URL path by type
     *
     * @param string $type
     * @param null|bool $secure
     * @return string
     */
    public function getBaseUrl($type = "link", $secure = null)
    {
        // TODO: Implement getBaseUrl() method.
    }

    /**
     * Generate url by route and parameters
     * @param   string $route
     * @param   array $params
     * @return  string
     */
    public function getUrl($route = '', $params = array())
    {
        // TODO: Implement getUrl() method.
    }

    /**
     * Get design package singleton
     *
     * @return Mage_Core_Model_Design_Package
     */
    public function getDesign()
    {
        // TODO: Implement getDesign() method.
    }

    /**
     * Add observer to even object
     *
     * @param string $eventName
     * @param callback $callback
     * @param array $data
     * @param string $observerName
     * @return \Varien_Event_Collection
     */
    public function addObserver($eventName, $callback, $data = array(), $observerName = '', $observerClass = '')
    {
        // TODO: Implement addObserver() method.
    }

    /**
     * Dispatch event
     *
     * Calls all observer callbacks registered for this event
     * and multiple observers matching event name pattern
     *
     * @param string $name
     * @param array $data
     * @return Mage_Core_Model_App
     */
    public function dispatchEvent($name, array $data = array())
    {
        // TODO: Implement dispatchEvent() method.
    }

    /**
     * Retrieve model object singleton
     *
     * @param   string $modelClass
     * @param   array $arguments
     * @return  Mage_Core_Model_Abstract
     */
    public function getSingleton($modelClass = '', array $arguments = array())
    {
        // TODO: Implement getSingleton() method.
    }

    /**
     * Retrieve object of resource model
     *
     * @param   string $modelClass
     * @param   array $arguments
     * @return  Object
     */
    public function getResourceModel($modelClass, $arguments = array())
    {
        // TODO: Implement getResourceModel() method.
    }

    /**
     * Retrieve Controller instance by ClassName
     *
     * @param string $class
     * @param Mage_Core_Controller_Request_Http $request
     * @param Mage_Core_Controller_Response_Http $response
     * @param array $invokeArgs
     * @return Mage_Core_Controller_Front_Action
     */
    public function getControllerInstance($class, $request, $response, array $invokeArgs = array())
    {
        // TODO: Implement getControllerInstance() method.
    }

    /**
     * Retrieve resource vodel object singleton
     *
     * @param   string $modelClass
     * @param   array $arguments
     * @return  object
     */
    public function getResourceSingleton($modelClass = '', array $arguments = array())
    {
        // TODO: Implement getResourceSingleton() method.
    }

    /**
     * Retrieve resource helper object
     *
     * @param string $moduleName
     * @return Mage_Core_Model_Resource_Helper_Abstract
     */
    public function getResourceHelper($moduleName)
    {
        // TODO: Implement getResourceHelper() method.
    }

    /**
     * Return new exception by module to be thrown
     *
     * @param string $module
     * @param string $message
     * @param integer $code
     * @return Mage_Core_Exception
     */
    public function exception($module = 'Mage_Core', $message = '', $code = 0)
    {
        // TODO: Implement exception() method.
    }

    /**
     * Throw Exception
     *
     * @param string $message
     * @param string $messageStorage
     * @throws Mage_Core_Exception
     */
    public function throwException($message, $messageStorage = null)
    {
        // TODO: Implement throwException() method.
    }

    /**
     * Get initialized application object.
     *
     * @param string $code
     * @param string $type
     * @param string|array $options
     * @return Mage_Core_Model_App
     */
    public function app($code = '', $type = 'store', $options = array())
    {
        // TODO: Implement app() method.
    }

    /**
     * @param string $code
     * @param string $type
     * @param array $options
     * @param string|array $modules
     */
    public function init($code = '', $type = 'store', $options = array(), $modules = array())
    {
        // TODO: Implement init() method.
    }

    /**
     * Front end main entry point
     *
     * @param string $code
     * @param string $type
     * @param string|array $options
     */
    public function run($code = '', $type = 'store', $options = array())
    {
        // TODO: Implement run() method.
    }

    /**
     * Retrieve application installation flag
     *
     * @param string|array $options
     * @return bool
     */
    public function isInstalled($options = array())
    {
        // TODO: Implement isInstalled() method.
    }

    /**
     * log facility
     *
     * @param string $message
     * @param integer $level
     * @param string $file
     * @param bool $forceLog
     */
    public function log($message, $level = null, $file = '', $forceLog = false)
    {
        // TODO: Implement log() method.
    }

    /**
     * Write exception to log
     *
     * @param Exception $e
     */
    public function logException(Exception $e)
    {
        // TODO: Implement logException() method.
    }

    /**
     * Set enabled developer mode
     *
     * @param bool $mode
     * @return bool
     */
    public function setIsDeveloperMode($mode)
    {
        // TODO: Implement setIsDeveloperMode() method.
    }

    /**
     * Retrieve enabled developer mode
     *
     * @return bool
     */
    public function getIsDeveloperMode()
    {
        // TODO: Implement getIsDeveloperMode() method.
    }

    /**
     * Display exception
     *
     * @param Exception $e
     */
    public function printException(Exception $e, $extra = '')
    {
        // TODO: Implement printException() method.
    }

    /**
     * Define system folder directory url by virtue of running script directory name
     * Try to find requested folder by shifting to domain root directory
     *
     * @param   string $folder
     * @param   boolean $exitIfNot
     * @return  string
     */
    public function getScriptSystemUrl($folder, $exitIfNot = false)
    {
        // TODO: Implement getScriptSystemUrl() method.
    }

    /**
     * Set is downloader flag
     *
     * @param bool $flag
     */
    public function setIsDownloader($flag = true)
    {
        // TODO: Implement setIsDownloader() method.
    }
}
