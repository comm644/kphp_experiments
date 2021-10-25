<?php

namespace Sigmalab\Database\Expressions;

class ExprAND extends ExprLogic
{
	/**
	 * ExprAND constructor.
	 * @param IExpression[]  $args
	 */
	function __construct(array $args)
	{
		parent::__construct("AND", $args);
	}
}