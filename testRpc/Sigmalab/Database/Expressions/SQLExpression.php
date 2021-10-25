<?php

namespace Sigmalab\Database\Expressions;


use Sigmalab\Database\Sql\SQLValue;

/** multiargument expression
 */
class SQLExpression implements IExpression, ICanCompileExpression
{
	/**
	 * @var string
	 */
	public string $mode = ""; //join mode
	/**
	 * @var mixed[]
	 */
	public array $args;      //array of arguments
	public string $type = "";      //type of values (need for type conversion)

	/**
	 * SQLExpression constructor.
	 * @param string $mode
	 * @param mixed[] $args
	 */
	function __construct(string $mode, array $args)
	{
		$this->mode = $mode;
		$this->args = $args;
	}

	function compile(ECompilerSQL $compiler): string
	{
		if (count($this->args) == 0) return ("");
		$query = "";
		$pos = 0;
		foreach ($this->args as $arg) {
			if ($pos > 0) $query .= " {$this->mode} ";
			$query .= $compiler->compile(new SQLValue($arg, $this->type), $this->type);
			$pos++;
		}
		return ($compiler->sqlGroup($query));
	}
}