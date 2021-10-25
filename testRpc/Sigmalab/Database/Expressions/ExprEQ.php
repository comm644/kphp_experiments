<?php

namespace Sigmalab\Database\Expressions;

use Sigmalab\Database\Core\DBColumnDefinition;

class ExprEQ extends ExprBool
{
	/**
	 * ExprEQ constructor.
	 * @param DBColumnDefinition $name
	 * @param mixed|null $arg
	 * @kphp-template $arg
	 */
	function __construct(DBColumnDefinition $name, $arg)
	{
		parent::__construct("=", $name, [$arg]);
	}

	public static function isNull(DBColumnDefinition $name)
	{
		$expr = new ExprEQ($name, 0);
		$expr->mode = "IS";
		$expr->args = [null];
		return $expr;
	}
	public static function eqInt(DBColumnDefinition $name, int $arg)
	{
		$expr = new ExprEQ($name, 0);
		$expr->mode = "=";
		$expr->args = [$arg];
		return $expr;
	}
	public static function eqString(DBColumnDefinition $name, string $arg)
	{
		$expr = new ExprEQ($name, "");
		$expr->mode = "=";
		$expr->args = [$arg];
		return $expr;
	}
}
