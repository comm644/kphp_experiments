<?php

namespace Sigmalab\Database\Expressions;

/**
 * This class provides mathematics for expressions.
 */
class ExprJoin extends SQLExpression
{
	function __construct($opcode)
	{
		$args = func_get_args();
		array_shift($args);
		parent::__construct($opcode, $args);
	}
}