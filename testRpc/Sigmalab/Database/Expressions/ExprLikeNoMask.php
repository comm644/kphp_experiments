<?php

namespace Sigmalab\Database\Expressions;

use Sigmalab\Database\Core\DBColumnDefinition;
use Sigmalab\Database\Sql\SQLValue;

class ExprLikeNoMask extends ExprLike
	implements ICanCompileExpression
{
	function __construct(DBColumnDefinition $name, $values)
	{
		parent::__construct($name, $values);
	}

	function compile(ECompilerSQL $compiler): string
	{
		if (count($this->args) == 0) return ("");
		$query = "";
		$pos = 0;
		foreach ($this->args as $arg) {
			if ($pos > 0) $query .= " {$compiler->sqlDic->sqlAnd} ";
			$query .= $compiler->compile($this->name, $this->type);
			$query .= " {$this->mode} ";
			$query .= $compiler->compileValue(new SQLValue($arg, $this->type));
			$pos++;
		}
		return ($compiler->sqlGroup($query));
	}
}