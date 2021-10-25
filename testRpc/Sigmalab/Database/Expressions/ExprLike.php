<?php

namespace Sigmalab\Database\Expressions;

use Sigmalab\Database\Core\DBColumnDefinition;

class ExprLike extends ExprBool implements ICanCompileExpression
{
	function __construct(DBColumnDefinition $name, $values)
	{
		parent::__construct("LIKE", $name, $values);
	}

	function compile(ECompilerSQL $compiler): string
	{
		$pos = 0;
		$query = "";
		foreach ($this->args as $arg) {
			if ($pos > 0) $query .= " {$compiler->sqlDic->sqlAnd} ";
			$query .= $compiler->compileLike($compiler->getName($this->name), (string)$arg);
			$pos++;
		}
		return ($compiler->sqlGroup($query));
	}
}