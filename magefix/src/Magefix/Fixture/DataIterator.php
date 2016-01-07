<?php

namespace Magefix\Fixture;

use Magefix\Exceptions\ProviderMethodNotFound;
use Magefix\Fixtures\Data\Provider;

/**
 * Class DataIterator
 *
 * @package Magefix\Fixture\Attributes
 * @author  Carlo Tasca <ctasca@sessiondigital.com>
 */
class DataIterator extends \ArrayIterator
{
    /**
     * @var Provider
     */
    private $_provider;

    /**
     * @param Provider $_provider
     * @return array
     */
    public function apply(Provider $_provider)
    {
        $this->_provider = $_provider;
        $data = $this->getArrayCopy();
        array_walk_recursive($data, [$this, 'traverse']);

        return $data;
    }

    /**
     * array_walk_recursive callback
     *
     * @param $value
     * @param $index
     */
    public function traverse(&$value, $index)
    {
        if (!is_numeric($index)) {
            $this->_setProvider($index, $value);
            $value = $this->_invokeProviderMethod($value);
        }
    }

    /**
     * @param Provider $provider
     * @param          $method
     *
     * @throws ProviderMethodNotFound
     *
     */
    protected function _throwMethodNotFoundExceptionForProvider(Provider $provider, $method)
    {
        throw new ProviderMethodNotFound(
            "Given provider does not have the method " . $method . ' -> ' . get_class($provider)
        );
    }

    /**
     * @param $index
     * @param $value
     */
    protected function _setProvider($index, $value)
    {
        if ($index == 'data_provider') {
            $dataProvider = new \ReflectionClass($value);
            $this->_provider = $dataProvider->newInstance();
        }
    }

    /**
     * @param $value
     * @return mixed
     * @throws ProviderMethodNotFound
     */
    protected function _invokeProviderMethod($value)
    {
        $return = $value;

        if ($this->_isReplaceableValue($value) !== false) {
            $return = $this->_replaceValue($value);
        }

        return $return;
    }

    /**
     * @param $method
     *
     * @return bool
     *
     */
    protected function _isInvokableForProviderInScope($method)
    {
        return method_exists($this->_provider, $method);
    }

    /**
     * @param $value
     * @return int|bool
     */
    protected function _isReplaceableValue($value)
    {
        return is_string($value) && preg_match('/^\{\{.*?\}\}$/i', $value);
    }

    /**
     * @param $value
     * @return mixed
     * @throws ProviderMethodNotFound
     */
    protected function _replaceValue($value)
    {
        $method = trim($value, '{}');

        if (!$this->_isInvokableForProviderInScope($method)) {
            $this->_throwMethodNotFoundExceptionForProvider($this->_provider, $method);
        }

        return $this->_provider->$method();
    }
}
