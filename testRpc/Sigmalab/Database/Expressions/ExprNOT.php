<?php
namespace Sigmalab\Database\Expressions;


class ExprNOT implements IExpression, ICanCompileExpression
{
	public IExpression $expr;
	/**
	 * @var string
	 */
	public string $name;

	public string $type = "";      //type of values (need for type conversion)

	function __construct($expr )
	{
		$this->name =" NOT ";
		$this->expr = $expr;
	}

	/**
	 * @param ECompilerSQL $compiler
	 * @return string
	 * @throws \Exception
	 */
	function compile(ECompilerSQL $compiler): string
	{
		$query = "";
		$query .= " {$this->name} ";
		$query .= $compiler->sqlGroup($compiler->compile($this->expr, $this->type));
		return $query;
	}
}
