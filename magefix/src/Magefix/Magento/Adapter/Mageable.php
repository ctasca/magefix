<?php
/**
 * Created by PhpStorm.
 * User: ctasca
 * Date: 23/07/2016
 * Time: 19:24
 */

namespace Magefix\Magento\Adapter;

use Exception;

/**
 * Interface Mageable
 * @package Magefix\Magento\Adapter
 */
interface Mageable extends Adaptable
{
    /**
     * Gets the current Magento version string
     * @link http://www.magentocommerce.com/blog/new-community-edition-release-process/
     *
     * @return string
     */
    public function getVersion();

    /**
     * Gets the detailed Magento version information
     * @link http://www.magentocommerce.com/blog/new-community-edition-release-process/
     *
     * @return array
     */
    public function getVersionInfo();

    /**
     * Get current Magento edition
     *
     * @
     * @return string
     */
    public function getEdition();

    /**
     * Set all my  data to defaults
     *
     */
    public function reset();

    /**
     * Register a new variable
     *
     * @param string $key
     * @param mixed $value
     * @param bool $graceful
     * @throws Mage_Core_Exception
     */
    public function register($key, $value, $graceful = false);

    /**
     * Unregister a variable from register by key
     *
     * @param string $key
     */
    public function unregister($key);

    /**
     * Retrieve a value from registry by a key
     *
     * @param string $key
     * @return mixed
     */
    public function registry($key);

    /**
     * Set application root absolute path
     *
     * @param string $appRoot
     * @throws Mage_Core_Exception
     */
    public function setRoot($appRoot = '');

    /**
     * Retrieve application root absolute path
     *
     * @return string
     */
    public function getRoot();

    /**
     * Retrieve Events Collection
     *
     * @return Varien_Event_Collection $collection
     */
    public function getEvents();

    /**
     * Varien Objects Cache
     *
     * @param string $key optional, if specified will load this key
     * @return Varien_Object_Cache
     */
    public function objects($key = null);

    /**
     * Retrieve application root absolute path
     *
     * @param string $type
     * @return string
     */
    public function getBaseDir($type = 'base');

    /**
     * Retrieve module absolute path by directory type
     *
     * @param string $type
     * @param string $moduleName
     * @return string
     */
    public function getModuleDir($type, $moduleName);

    /**
     * Retrieve config value for store by path
     *
     * @param string $path
     * @param mixed $store
     * @return mixed
     */
    public function getStoreConfig($path, $store = null);

    /**
     * Retrieve config flag for store by path
     *
     * @param string $path
     * @param mixed $store
     * @return bool
     */
    public function getStoreConfigFlag($path, $store = null);

    /**
     * Get base URL path by type
     *
     * @param string $type
     * @param null|bool $secure
     * @return string
     */
    public function getBaseUrl($type = "link", $secure = null);

    /**
     * Generate url by route and parameters
     * @param   string $route
     * @param   array $params
     * @return  string
     */
    public function getUrl($route = '', $params = array());

    /**
     * Get design package singleton
     *
     * @return Mage_Core_Model_Design_Package
     */
    public function getDesign();

    /**
     * Retrieve a config instance
     *
     * @return Mage_Core_Model_Config
     */
    public function getConfig();

    /**
     * Add observer to even object
     *
     * @param string $eventName
     * @param callback $callback
     * @param array $data
     * @param string $observerName
     * @return \Varien_Event_Collection
     */
    public function addObserver($eventName, $callback, $data = array(), $observerName = '', $observerClass = '');

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
    public function dispatchEvent($name, array $data = array());

    /**
     * Retrieve model object
     *
     * @link    Mage_Core_Model_Config::getModelInstance
     * @param   string $modelClass
     * @param   array|object $arguments
     * @return  Mage_Core_Model_Abstract|false
     */
    public function getModel($modelClass = '', $arguments = array());

    /**
     * Retrieve model object singleton
     *
     * @param   string $modelClass
     * @param   array $arguments
     * @return  Mage_Core_Model_Abstract
     */
    public function getSingleton($modelClass = '', array $arguments = array());

    /**
     * Retrieve object of resource model
     *
     * @param   string $modelClass
     * @param   array $arguments
     * @return  Object
     */
    public function getResourceModel($modelClass, $arguments = array());

    /**
     * Retrieve Controller instance by ClassName
     *
     * @param string $class
     * @param Mage_Core_Controller_Request_Http $request
     * @param Mage_Core_Controller_Response_Http $response
     * @param array $invokeArgs
     * @return Mage_Core_Controller_Front_Action
     */
    public function getControllerInstance($class, $request, $response, array $invokeArgs = array());

    /**
     * Retrieve resource vodel object singleton
     *
     * @param   string $modelClass
     * @param   array $arguments
     * @return  object
     */
    public function getResourceSingleton($modelClass = '', array $arguments = array());

    /**
     * Retrieve helper object
     *
     * @param string $name the helper name
     * @return Mage_Core_Helper_Abstract
     */
    public function helper($name);

    /**
     * Retrieve resource helper object
     *
     * @param string $moduleName
     * @return Mage_Core_Model_Resource_Helper_Abstract
     */
    public function getResourceHelper($moduleName);

    /**
     * Return new exception by module to be thrown
     *
     * @param string $module
     * @param string $message
     * @param integer $code
     * @return Mage_Core_Exception
     */
    public function exception($module = 'Mage_Core', $message = '', $code = 0);

    /**
     * Throw Exception
     *
     * @param string $message
     * @param string $messageStorage
     * @throws Mage_Core_Exception
     */
    public function throwException($message, $messageStorage = null);

    /**
     * Get initialized application object.
     *
     * @param string $code
     * @param string $type
     * @param string|array $options
     * @return Mage_Core_Model_App
     */
    public function app($code = '', $type = 'store', $options = array());

    /**
     * @param string $code
     * @param string $type
     * @param array $options
     * @param string|array $modules
     */
    public function init($code = '', $type = 'store', $options = array(), $modules = array());

    /**
     * Front end main entry point
     *
     * @param string $code
     * @param string $type
     * @param string|array $options
     */
    public function run($code = '', $type = 'store', $options = array());

    /**
     * Retrieve application installation flag
     *
     * @param string|array $options
     * @return bool
     */
    public function isInstalled($options = array());

    /**
     * log facility
     *
     * @param string $message
     * @param integer $level
     * @param string $file
     * @param bool $forceLog
     */
    public function log($message, $level = null, $file = '', $forceLog = false);

    /**
     * Write exception to log
     *
     * @param Exception $e
     */
    public function logException(Exception $e);

    /**
     * Set enabled developer mode
     *
     * @param bool $mode
     * @return bool
     */
    public function setIsDeveloperMode($mode);

    /**
     * Retrieve enabled developer mode
     *
     * @return bool
     */
    public function getIsDeveloperMode();

    /**
     * Display exception
     *
     * @param Exception $e
     */
    public function printException(Exception $e, $extra = '');

    /**
     * Define system folder directory url by virtue of running script directory name
     * Try to find requested folder by shifting to domain root directory
     *
     * @param   string  $folder
     * @param   boolean $exitIfNot
     * @return  string
     */
    public function getScriptSystemUrl($folder, $exitIfNot = false);

    /**
     * Set is downloader flag
     *
     * @param bool $flag
     */
    public function setIsDownloader($flag = true);
}
