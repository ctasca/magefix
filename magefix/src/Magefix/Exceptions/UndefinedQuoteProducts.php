<?php

namespace Magefix\Exceptions;

/**
 * Class UndefinedQuoteProducts
 *
 * Thrown when trying to create a SalesOrder fixture but
 * checkout product fixtures have not been defined.
 *
 * @package Magefix\Exceptions
 * @author  Carlo Tasca <ctasca.d3@gmail.com>
 */
class UndefinedQuoteProducts extends \Exception
{

}
