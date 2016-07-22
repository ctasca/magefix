<?php

namespace Magefix\Behat;

/**
 * Class Hook
 *
 * @package Magefix\Behat
 * @author  Carlo Tasca <ctasca.d3@gmail.com>
 */
trait Hook
{
    /**
     * @BeforeSuite
     */
    public static function beforeSuiteFixturesCleanup()
    {
        self::_cleanupFixtureByHook('beforesuite');
    }

    /**
     * @AfterSuite
     */
    public static function afterSuiteFixturesCleanup()
    {
        self::_cleanupFixtureByHook('aftersuite');
    }

    /**
     * @BeforeFeature
     */
    public static function beforeFeatureFixturesCleanup()
    {
        self::_cleanupFixtureByHook('beforefeature');
    }

    /**
     * @AfterFeature
     */
    public static function afterFeatureFixturesCleanup()
    {
        self::_cleanupFixtureByHook('afterfeature');
    }

    /**
     * @BeforeScenario
     */
    public function beforeScenarioFixturesCleanup()
    {
        self::_cleanupFixtureByHook('beforescenario');
    }

    /**
     * @AfterScenario
     */
    public function afterScenarioFixturesCleanup()
    {
        self::_cleanupFixtureByHook('afterscenario');
    }

    /**
     * @BeforeStep
     */
    public function beforeStepFixturesCleanup()
    {
        self::_cleanupFixtureByHook('beforestep');
    }

    /**
     * @AfterStep
     */
    public function afterStepFixturesCleanup()
    {
        self::_cleanupFixtureByHook('afterstep');
    }
}
