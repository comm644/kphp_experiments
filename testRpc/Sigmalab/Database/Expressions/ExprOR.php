<?php

namespace Sigmalab\Database\Expressions;

class ExprOR extends ExprLogic
{
	/**
	 * ExprOR constructor.
	 * @param  IExpression[]  $args
	 */
	function __construct(array $args)
	{
		parent::__construct("OR", $args);
	}
}