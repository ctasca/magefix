<?php

namespace Magefix\Fixture\Factory;

use Mage;
use Magefix\Exceptions\UnknownFixtureType;
use Magefix\Fixtures\Data\Provider;
use Magefix\Fixtures\Registry;
use Magefix\Parser\ResourceLocator;
use Magefix\Yaml\Parser as YamlParser;
use Magefix\Fixture\Builder\Customer as CustomerFixture;
use Magefix\Fixture\Builder\AbstractBuilder as FixtureBuilder;

/**
 * Class Builder
 *
 * Provide utility method build to build Fixtures
 *
 * @package Magefix\Fixture\Factory
 * @author  Carlo Tasca <ctasca@sessiondigital.com>
 */
class Builder
{
    const SIMPLE_PRODUCT_FIXTURE_TYPE = 'Product';
    const CONFIGURABLE_PRODUCT_FIXTURE_TYPE = 'ConfigurableProduct';
    const BUNDLE_PRODUCT_FIXTURE_TYPE = 'BundleProduct';
    const SALES_ORDER_FIXTURE_TYPE = 'SalesOrder';
    const CATEGORY_FIXTURE_TYPE = 'Category';
    const CUSTOMER_FIXTURE_TYPE = 'Customer';

    use Registry;

    /**
     * @param string          $fixtureType
     * @param ResourceLocator $locator
     * @param Provider        $dataProvider
     * @param string          $yamlFilename
     * @param bool|string     $hook
     *
     * @return int
     * @throws UnknownFixtureType
     * @throws \Magefix\Exceptions\UnavailableHook
     */
    public static function build(
        $fixtureType, ResourceLocator $locator, Provider $dataProvider, $yamlFilename, $hook = false
    ) {
        $parser    = new YamlParser($locator, $yamlFilename);
        $fixtureData = is_array($parser->parse()) ? $parser->parse() : [];
        $fixture   = self::instantiateFixture($fixtureType, $dataProvider, $fixtureData, $hook);
        $fixtureId = $fixture->build();

        if ($hook) {
            self::registerFixture($fixtureType, $fixtureId, $hook);
        }

        return $fixtureId;
    }

    /**
     * @param                $fixtureType
     * @param FixtureBuilder $builder
     * @param array          $entities
     * @param bool|string    $hook
     *
     * @return array
     * @throws UndefinedFixtureModel
     * @throws UnknownFixtureType
     * @throws \Magefix\Exceptions\UnavailableHook
     */
    public static function buildMany($fixtureType, FixtureBuilder $builder, array $entities, $hook = false)
    {
        $many = [];

        foreach ($entities as $entity) {
            $builder->throwUndefinedDataProvider($entity);
            $fixtureData = [];
            $dataProvider           = new $entity['data_provider']();
            $fixtureData['fixture'] = $entity;
            $fixture                = self::instantiateFixture($fixtureType, $dataProvider, $fixtureData, $hook);

            $fixtureId = $fixture->build();

            self::registerFixture(
                $fixtureType, $fixtureId, $fixture->getHook()
            );

            if (!isset($entity['model'])) {
                throw new UndefinedFixtureModel(
                    'Magento model has not been defined. Check fixture yml.'
                );
            }

            $many[] = Mage::getModel($entity['model'])->load($fixtureId);
        }

        return $many;
    }

    /**
     * @param string      $fixtureType
     * @param Provider    $dataProvider
     * @param array       $parsedData
     * @param string|bool $hook
     *
     * @return CustomerFixture|ProductFixture|null
     * @throws UnknownFixtureType
     */
    protected static function instantiateFixture($fixtureType, Provider $dataProvider, array $parsedData, $hook)
    {
        $mageModel = Mage::getModel($parsedData['fixture']['model']);
        $class = new \ReflectionClass('Magefix\Fixture\Builder\\' . $fixtureType);
        $fixture = $class->newInstanceArgs([$parsedData, $mageModel, $dataProvider, $hook]);

        return $fixture;
    }
}
