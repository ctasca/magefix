<?php

namespace Magefix\Fixtures;

use Mage;
use Mage_Core_Model_Abstract;
use Magefix\Fixture\Factory\Builder;
use Magefix\Magento\Model\Mapper;

/**
 * Class RegistryIterator
 *
 * @package Magefix\Fixtures
 * @author  Carlo Tasca <ctasca@sessiondigital.com>
 */
class RegistryIterator extends \ArrayObject
{
    /**
     * @param $hook
     *
     */
    public function iterateByHook($hook)
    {
        $registryIteratorIterator = $this->getIterator();

        while ($registryIteratorIterator->valid()) {
            $key        = $registryIteratorIterator->key();
            $entry      = $registryIteratorIterator->current();
            $entryMatch = $this->isEntryMatch($hook, $key);

            $this->_changeRegistryEntry($entryMatch, $entry, $key);

            $registryIteratorIterator->next();
        }
    }

    /**
     * @param string $match
     * @return Mage_Core_Model_Abstract
     */
    public function getMageModelForMatch($match)
    {
        $model = Mapper::map($match);
        return Mage::getModel($model);
    }

    /**
     * @param $hook
     * @param $key
     *
     * @return string[]
     *
     */
    public function isEntryMatch($hook, $key)
    {
        return RegistryEntryMatcher::match($hook, $key);
    }

    /**
     * @param                          $model
     * @param string                   $fixtureType
     * @param                          $entry
     * @param                          $key
     */
    protected function _echoRegistryChangeMessage($model, $fixtureType, $entry, $key)
    {
        echo $this->_deleteAndUnregisterFixture(
            $model, $fixtureType, $entry, $key
        );
    }

    /**
     * @param Mage_Core_Model_Abstract $model
     * @param string                   $fixtureType
     * @param                          $entry
     * @param                          $key
     *
     * @return string
     * @throws \Exception
     */
    protected function _deleteAndUnregisterFixture(Mage_Core_Model_Abstract $model, $fixtureType, $entry, $key)
    {
        $fixture = $model->load((int) $entry);
        $fixture->delete();
        Builder::unregister($key);

        return $this->_deleteFixtureMessage($fixtureType, $entry);
    }

    /**
     * @param string $fixtureType
     * @param string $entry
     *
     * @return string
     */
    protected function _deleteFixtureMessage($fixtureType, $entry)
    {
        return "-- DELETED {$fixtureType} fixture with ID {$entry}\n";
    }

    /**
     * @param array $entryMatch
     * @param       $entry
     * @param       $key
     *
     * @throws \Exception
     */
    protected function _changeRegistryEntry(array $entryMatch, $entry, $key)
    {
        $mageModel = $this->_instantiateMageModel($entryMatch);

        if ($this->_isExpectedType($mageModel)) {
            $this->_echoRegistryChangeMessage(
                $mageModel, $entryMatch[1], $entry, $key
            );
        }
    }

    /**
     * @param $mageModel
     *
     * @return bool
     *
     */
    protected function _isExpectedType($mageModel)
    {
        return !is_null($mageModel) && is_a($mageModel, 'Mage_Core_Model_Abstract');
    }

    /**
     * @param array $entryMatch
     *
     * @return array
     * @throws \Exception
     *
     */
    protected function _instantiateMageModel(array $entryMatch)
    {
        if (!isset($entryMatch[1])) {
            return;
        }

        $mageModel = $this->getMageModelForMatch($entryMatch[1]);

        if (is_null($mageModel)) {
            throw new \Exception('Cannot initialise Magento model from registry entry match.');
        }

        return $mageModel;
    }
}
