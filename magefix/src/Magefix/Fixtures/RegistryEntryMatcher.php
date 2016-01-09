<?php

namespace Magefix\Fixtures;


use Magefix\Fixture\Factory\Builder;
use Magefix\Magento\Model\Mapper;

/**
 * Class RegistryEntryMatcher
 *
 * @package Magefix\Fixtures
 * @author  Carlo Tasca <ctasca@sessiondigital.com>
 */
class RegistryEntryMatcher
{
    /**
     * @param string $hook
     * @param string $key
     * @return array
     */
    public static function match($hook, $key)
    {
        $matches = [];
        $matchOr = self::_matchOr();

        preg_match("/^({$matchOr})_{$hook}/", $key, $matches);

        return $matches;
    }

    /**
     * @return string
     */
    private static function _matchOr()
    {
        $mapperKeys = array_keys(Mapper::getMap());
        $matchOr = implode('|', $mapperKeys);

        return $matchOr;
    }
}