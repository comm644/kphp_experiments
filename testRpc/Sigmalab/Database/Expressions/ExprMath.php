<?php

namespace Sigmalab\Database\Expressions;

/**
 * This class provides mathematics for expressions.
 */
class ExprMath extends SQLExpression
{
	function __construct($opcode, $arg0, $arg1)
	{
		$args = [$arg0, $arg1];
		parent::__construct($opcode, $args);
	}
}