<?php

namespace Sigmalab\Database\Expressions;

use Sigmalab\Database\Core\DBColumnDefinition;
use Sigmalab\Database\Sql\SQLValue;

/** bool expression
 */
class ExprBool extends SQLExpression
{
	/**
	 * @var DBColumnDefinition
	 */
	public $name;

	/**
	 * ExprBool constructor.
	 * @param string $mode
	 * @param DBColumnDefinition $name
	 * @param mixed[] $values
	 */
	function __construct(string $mode, DBColumnDefinition $name, array $values)
	{
		parent::__construct($mode, $values);

		$this->name = $name;
		$this->type = (string)$name->type;
	}

	function compile(ECompilerSQL $compiler): string
	{
		$pos = 0;
		$query = "";

		if ($this->mode == "IS") {
			$query .= $compiler->getName($this->name) . ' ' . $this->mode . ' NULL';
		} else if ($this->mode == "IS NOT") {
			$query .= $compiler->getName($this->name) . ' ' . $this->mode . ' NULL';
		} else if (!is_array($this->args)) {
			$query .= $compiler->getName($this->name)
				. ' ' . $this->mode
				. ' ' . $compiler->compile(new SQLValue($this->args[0], $this->type), $this->type);
		} else {
			$parts = array();

			foreach ($this->args as $arg) {
				if ($pos > 0) $parts[] = $compiler->sqlDic->sqlAnd;
				$parts[] = $compiler->getName($this->name);
				$parts[] = $this->mode;
				$parts[] = $compiler->compile(new SQLValue($arg, $this->type), $this->type);
				$pos++;
			}
			$query .= implode(' ', $parts);
		}
		return ($compiler->sqlGroup($query));
	}
}