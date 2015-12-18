<?php

namespace Magefix\Behat;

/**
 * Class Hook
 *
 * @package Magefix\Behat
 * @author  Carlo Tasca <ctasca@sessiondigital.com>
 */
trait Hook
{
    /**
     * @AfterSuite
     */
    public static function afterSuiteFixturesCleanup()
    {
        self::_cleanupFixtureByHook('aftersuite');
    }

    /**
     * @AfterFeature
     */
    public static function afterFeatureFixturesCleanup()
    {
        self::_cleanupFixtureByHook('afterfeature');
    }

    /**
     * @AfterScenario
     */
    public function afterScenarioFixturesCleanup()
    {
        self::_cleanupFixtureByHook('afterscenario');
    }

    /**
     * @AfterStep
     */
    public function afterStepFixturesCleanup()
    {
        self::_cleanupFixtureByHook('afterstep');
    }
}
