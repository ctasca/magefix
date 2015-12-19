<?php

namespace Magefix\Fixture\Builder;

use Mage_Core_Model_Abstract as MagentoModel;
use Magefix\Exceptions\UndefinedDataProvider;
use Magefix\Fixture\Builder;
use Magefix\Fixture\Factory\Builder as FixtureBuilder;
use Magefix\Fixtures\Data\Provider;
use Magefix\Magento\Store\Scope as MagentoStoreScope;
use Magefix\Exceptions\ProviderMethodNotFound;
use Magefix\Exceptions\UndefinedAttributes;

/**
 * Class AbstractBuilder
 *
 * @package Magefix\Fixture\Builder
 * @author  Carlo Tasca <ctasca@sessiondigital.com>
 */
abstract class AbstractBuilder implements Builder
{
    /**
     * @var MagentoModel
     */
    private $_mageModel;
    /**
     * @var Provider
     */
    private $_dataProvider;

    /**
     * @var string
     */
    private $_hook;

    /**
     * @var array
     */
    protected $_data;

    public function __construct(array $parserData, MagentoModel $model, Provider $dataProvider, $hook)
    {
        $this->_mageModel    = $model;
        $this->_dataProvider = $dataProvider;
        $this->_data         = $parserData;
        $this->_hook         = $hook;
    }

    /**
     *
     * Concrete classes to provide implementation for build method
     *
     * @return mixed
     */
    abstract public function build();

    /**
     * @return MagentoModel
     * @throws \Exception
     */
    public function getMageModel()
    {
        return $this->_getMageModel();
    }

    /**
     * @return string
     */
    public function getHook()
    {
        return $this->_getHook();
    }

    /**
     * @param $entity
     *
     * @throws UndefinedDataProvider
     *
     */
    public function throwUndefinedDataProvider($entity)
    {
        $this->_throwUndefinedDataProvider($entity);
    }

    /**
     * @param array $attributes
     *
     * @return array
     * @throws \Exception
     */
    public function processFixtureAttributes(array $attributes)
    {
        $fixtureAttributes = $this->_processFixtureAttributesWithProvider($attributes, $this->_getDataProvider());

        return $fixtureAttributes;
    }

    /**
     * @param array    $attributes
     * @param Provider $dataProvider
     *
     */
    public function processFixtureAttributesWithProvider(array $attributes, Provider $dataProvider)
    {
        $this->_processFixtureAttributesWithProvider($attributes, $dataProvider);
    }

    /**
     * @param $mageModel
     * @param $data
     *
     */
    public function saveFixtureWithModelAndData($mageModel, $data)
    {
        $this->_saveFixtureWithModelAndData($mageModel, $data);
    }

    /**
     * @return array
     * @throws \Exception
     */
    protected function _getMageModelData()
    {
        return $this->_getMageModel()->getData();
    }

    /**
     * @return MagentoModel
     */
    protected function _getMageModel()
    {
        return $this->_mageModel;
    }

    /**
     * @return mixed
     */
    protected function _getDataProvider()
    {
        return $this->_dataProvider;
    }

    /**
     * @return string
     */
    protected function _getHook()
    {
        return $this->_hook;
    }

    /**
     * @return array
     * @throws \Exception
     */
    protected function _getFixtureAttributes()
    {
        $this->_throwUndefinedAttributesException(isset($this->_data['fixture']['attributes']));

        return $this->_processFixtureAttributes($this->_data['fixture']['attributes']);
    }

    /**
     * @param array $attributes
     *
     * @return array
     * @throws \Exception
     */
    protected function _processFixtureAttributes(array $attributes)
    {
        $fixtureAttributes = $this->_processFixtureAttributesWithProvider($attributes, $this->_getDataProvider());

        return $fixtureAttributes;
    }

    /**
     * @param array    $attributes
     * @param Provider $provider
     *
     * @return array
     * @throws ProviderMethodNotFound
     */
    private function _processFixtureAttributesWithProvider(array $attributes, Provider $provider)
    {
        $fixtureAttributes = [];
        foreach ($attributes as $key => $attributeValue) {
            if (is_array($attributeValue)) {
                $fixtureAttributes[$key] = $attributeValue;
                continue;
            }
            if (preg_match('/^\{\{.*?\}\}$/i', $attributeValue)) {
                $method = trim($attributeValue, '{}');
                $this->_throwMethodNotFoundExceptionForProvider($provider, $method);
                $fixtureAttributes[$key] = $provider->$method();
            } else {
                $fixtureAttributes[$key] = $attributeValue;
            }
        }

        return $fixtureAttributes;
    }

    /**
     * @return int
     * @throws \Exception
     */
    protected function _saveFixture()
    {
        MagentoStoreScope::setAdminStoreScope();
        $this->_getMageModel()->save();
        MagentoStoreScope::setCurrentStoreScope();

        return $this->_getMageModel()->getId();
    }

    /**
     * @param MagentoModel $mageModel
     * @param              $data
     *
     * @return int
     * @throws NullFixtureId
     */
    protected function _saveFixtureWithModelAndData(MagentoModel $mageModel, $data)
    {
        MagentoStoreScope::setAdminStoreScope();
        $mageModel->setData($data);
        $mageModel->save();
        MagentoStoreScope::setCurrentStoreScope();

        return $mageModel->getId();
    }

    /**
     * Add data to model, but don't save fixture
     *
     * @param array $data
     *
     * @return int
     * @throws NullFixtureId
     */
    protected function _initFixtureWithData(array $data)
    {
        $this->_getMageModel()->setData($data);
    }

    /**
     * @param $node
     *
     * @return array
     */
    protected function _buildManySimple($node)
    {
        $products = $this->_data['fixture'][$node]['products'];

        return FixtureBuilder::buildMany(
            FixtureBuilder::SIMPLE_PRODUCT_FIXTURE_TYPE, $this, $products, $this->getHook()
        );
    }


    /**
     * @param boolean $isSet
     * @param string  $message
     *
     * @throws UndefinedAttributes
     *
     */
    protected function _throwUndefinedAttributesException(
        $isSet, $message = 'Fixture attributes have not been defined. Check fixture yml file.'
    ) {
        if (!$isSet) {
            throw new UndefinedAttributes($message);
        }
    }

    /**
     * @param array $a
     *
     * @throws UndefinedDataProvider
     *
     */
    protected function _throwUndefinedDataProvider(array $a)
    {
        if (!isset($a['data_provider'])) {
            throw new UndefinedDataProvider(
                'Fixture has no data provider specified. Check fixture yml file.'
            );
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
        if (!method_exists($provider, $method)) {
            throw new ProviderMethodNotFound(
                "Given provider does not have the method " . $method . ' -> ' . get_class($provider)
            );
        }
    }
}
