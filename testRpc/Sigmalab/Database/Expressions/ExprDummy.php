<?php

namespace Sigmalab\Database\Expressions;

class ExprDummy implements IExpression, ICanCompileExpression
{
	/**
	 * @var IExpression[]
	 */
	public array $args;

	/**
	 * ExprDummy constructor.
	 * @param IExpression[] $args
	 */
	public function __construct(array $args)
	{
		$this->args = $args;
	}

	function compile(ECompilerSQL $compiler): string
	{
		if (count($this->args) == 0) return ("");
		$query = "";
		foreach ($this->args as $arg) {
			$query .= $compiler->compile($arg);
		}
		return ($query);
	}
}