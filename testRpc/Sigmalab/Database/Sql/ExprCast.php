<?php

namespace Sigmalab\Database\Sql;

use Sigmalab\Database\Expressions\ECompilerSQL;
use Sigmalab\Database\Expressions\ICanCompileExpression;
use Sigmalab\Database\Expressions\IExpression;
use Sigmalab\Database\Expressions\SQLExpression;

class ExprCast implements IExpression, ICanGenerateOne, ICanCompileExpression

{
	public string  $type;
	public  IExpression $value;

	/**
	 * ExprCast constructor.
	 * @param $type
	 * @param $value
	 */
	public function __construct(string $type, SQLExpression $value)
	{
		$this->type = $type;
		$this->value = $value;
	}

	/** Generate SQL code for defined column in SQL
	 *
	 * @param SQLGenerator $generator
	 * @param int $cause cause of generation, see:
	 * @return string
	 * @see \Sigmalab\Database\Core\DBGenCause
	 */
	function generate(SQLGenerator $generator, $cause=0):string
	{
		$parts = array(
			$generator->getDictionary()->sqlCast,
			$generator->getDictionary()->sqlOpenFuncParams,
			ECompilerSQL::s_compile($this->value, $generator),
			$generator->generateTypeCastTo($this->type),
			$generator->getDictionary()->sqlCloseFuncParams
		);
		return implode("", $parts);
	}

	function compile(ECompilerSQL $compiler): string
	{
		return $this->generate($compiler->generator, 0);
	}
}