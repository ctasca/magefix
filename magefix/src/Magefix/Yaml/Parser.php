<?php

namespace Magefix\Yaml;

use Magefix\Exceptions\UndefinedFixtureModel;
use Magefix\Parser\ResourceLocator as Locator;
use Symfony\Component\Yaml\Yaml;
/**
 * Class Parser
 *
 * Parse YAML files
 *
 * @package Magefix\Yaml
 * @author  Carlo Tasca <ctasca@inviqa.com>
 */
class Parser implements \Magefix\Parser
{
    /**
     * @var Locator
     */
    private $_locator;

    /**
     * @var string
     */
    private $_filename;

    public function __construct(Locator $locator, $filename)
    {
        $this->_locator  = $locator;
        $this->_filename = $filename;
    }

    /**
     * @return array
     */
    public function parse()
    {
        return Yaml::parse($this->getFixturesLocation() . $this->_filename);
    }

    /**
     * @return string
     */
    public function getFixturesLocation()
    {
        return $this->_locator->getLocation();
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function getMageModel()
    {
        $data = $this->parse();

        if (!isset($data['fixture']['model'])) {
            throw new UndefinedFixtureModel('A fixture model has not been set. Check yaml file.');
        }

        return $data['fixture']['model'];
    }
}
