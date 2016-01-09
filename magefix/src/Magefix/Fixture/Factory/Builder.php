<?php

namespace Magefix\Fixture\Factory;

use Mage;
use Magefix\Exceptions\UndefinedFixtureModel;
use Magefix\Exceptions\UnknownFixtureType;
use Magefix\Fixture\Instanciator;
use Magefix\Fixture\Typeable;
use Magefix\Fixtures\Registry;
use Magefix\Parser\ResourceLocator;
use Magefix\Yaml\Parser as YamlParser;
use Magefix\Fixture\Builder\AbstractBuilder as FixtureBuilder;

/**
 * Class Builder
 *
 * Provide utility method build to build Fixtures
 *
 * @package Magefix\Fixture\Factory
 * @author  Carlo Tasca <ctasca@sessiondigital.com>
 */
final class Builder implements Typeable
{
    use Registry;

    /**
     * @param string $fixtureType
     * @param ResourceLocator $locator
     * @param string $yamlFilename
     * @param bool|string $hook
     *
     * @return int
     * @throws UnknownFixtureType
     * @throws \Magefix\Exceptions\UnavailableHook
     */
    public static function build($fixtureType, ResourceLocator $locator, $yamlFilename, $hook = '')
    {
        $parser = new YamlParser($locator, $yamlFilename);
        $fixtureData = is_array($parser->parse()) ? $parser->parse() : [];
        $fixture = Instanciator::instance($fixtureType, $fixtureData, $hook);
        $fixtureId = $fixture->build();

        if ($hook) {
            self::registerFixture($fixtureType, $fixtureId, $hook);
        }

        return $fixtureId;
    }

    /**
     * @param $fixtureType
     * @param FixtureBuilder $builder
     * @param array $entities
     * @param string $hook
     * @return array
     * @throws UndefinedFixtureModel
     */
    public static function buildMany($fixtureType, FixtureBuilder $builder, array $entities, $hook = '')
    {
        $many = [];

        $iterator = new \ArrayIterator($entities);

        while ($iterator->valid()) {
            $builder->throwUndefinedDataProvider($iterator->current());
            $fixtureId = self::_buildAndRegisterFixture($fixtureType, $hook, $iterator->current());
            $many[] = self::_getMagentoModel($iterator->current(), $fixtureId);

            $iterator->next();
        }

        return $many;
    }

    /**
     * @param $fixtureType
     * @param $hook
     * @param $entity
     * @return mixed
     */
    protected static function _buildAndRegisterFixture($fixtureType, $hook, $entity)
    {
        $fixtureData = [];
        $fixtureData['fixture'] = $entity;

        $fixture = Instanciator::instance($fixtureType, $fixtureData, $hook);

        $fixtureId = $fixture->build();

        self::registerFixture(
            $fixtureType, $fixtureId, $fixture->getHook()
        );
        return $fixtureId;
    }

    /**
     * @param $entity
     * @param $fixtureId
     * @return \Mage_Core_Model_Abstract
     * @throws UndefinedFixtureModel
     */
    private static function _getMagentoModel($entity, $fixtureId)
    {
        if (!isset($entity['model'])) {
            throw new UndefinedFixtureModel(
                'Magento model has not been defined. Check fixture yml.'
            );
        }

        return Mage::getModel($entity['model'])->load($fixtureId);
    }
}
