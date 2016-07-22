<?php

namespace Magefix;

/**
 * Interface Parser
 *
 * @package Magefix
 * @author  Carlo Tasca <ctasca.d3@gmail.com>
 */
interface Parser
{
    public function parse();

    public function getMageModel();
}
