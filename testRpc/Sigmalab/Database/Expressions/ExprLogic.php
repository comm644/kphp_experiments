<?php

namespace Sigmalab\Database\Expressions;

class ExprLogic implements IExpression
{
	/**
	 * @var string
	 */
	public string $mode = ""; //join mode
	/**
	 * @var IExpression[]
	 */
	public array $args;      //array of arguments

	/**
	 * SQLExpression constructor.
	 * @param string $mode
	 * @param IExpression[] $args
	 */
	function __construct(string $mode, array $args)
	{
		$this->mode = $mode;
		$this->args = $args;
	}

}