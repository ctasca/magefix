<?php

namespace Magefix\Exceptions;

/**
 * Class UndefinedUsedProductAttributeIds
 *
 * Thrown when creating ConfigurableProduct fixtures and used_product_attributes have
 * not been defined in fixture YAML.
 *
 * @package Magefix\Exceptions
 * @author  Carlo Tasca <ctasca@sessiondigital.com>
 */
class UndefinedUsedProductAttributeIds extends \Exception
{

}
