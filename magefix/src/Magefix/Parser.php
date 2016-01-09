<?php

namespace Magefix;

/**
 * Interface Parser
 *
 * @package Magefix
 * @author  Carlo Tasca <ctasca@inviqa.com>
 */
interface Parser
{
    public function parse();

    public function getMageModel();
}
