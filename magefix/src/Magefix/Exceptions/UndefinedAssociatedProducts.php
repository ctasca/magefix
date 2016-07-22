<?php

namespace Magefix\Exceptions;

/**
 * Class UndefinedAssociatedProducts
 *
 * Thrown when creating ConfigurableProduct fixtures and associated products have
 * not been defined in fixture YAML.
 *
 * @package Magefix\Exceptions
 * @author  Carlo Tasca <ctasca.d3@gmail.com>
 */
class UndefinedAssociatedProducts extends \Exception
{

}
