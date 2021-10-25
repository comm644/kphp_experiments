<?php

namespace Sigmalab\Database\Expressions;

/**
 * Raw condition. Do not use it.
 *
 */
class ExprRaw extends SQLExpression implements ICanCompileExpression
{
	/**
	 * raw condition
	 *
	 * @var string
	 */
	var $raw;

	/**
	 * construct expresion
	 *
	 * @param string $rawCondition
	 */
	function __construct(string $rawCondition)
	{
		$this->raw = $rawCondition;
		parent::__construct(null, null);
	}

	function compile(ECompilerSQL $compiler): string
	{
		return $this->raw;
	}
}