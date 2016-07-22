<?php

namespace Magefix\Fixture;
use Mage;

/**
 * Class Instanciator
 * @package Magefix\Fixture
 * @author  Carlo Tasca <ctasca.d3@gmail.com>
 */
final class Instanciator
{
    const BUILDER_NAMESPACE_PREFIX = 'Magefix\Fixture\Builder\\';

    /**
     * @param $fixtureType
     * @param array $instanceData
     * @param $hook
     * @return object
     */
    public static function instance($fixtureType, array $instanceData, $hook)
    {
        $mageModel = Mage::getModel($instanceData['fixture']['model']);
        $class = new \ReflectionClass(static::BUILDER_NAMESPACE_PREFIX . $fixtureType);
        $fixture = $class->newInstanceArgs([$instanceData, $mageModel, $hook]);

        return $fixture;
    }
}
