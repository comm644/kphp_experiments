<?php

namespace Sigmalab\Database\Expressions;

use Sigmalab\Database\Core\DBColumnDefinition;
use Sigmalab\Database\Sql\SQLValue;

class ExprIN extends ExprSet
{
	/**
	 * @var DBColumnDefinition
	 */
	public $name;

	/**
	 * ExprIN constructor.
	 * @param DBColumnDefinition $name
	 * @param mixed[] $values
	 */
	function __construct(DBColumnDefinition $name, array $values)
	{
		parent::__construct("IN", $values);
		$this->name = $name;
	}


	function compile(ECompilerSQL $compiler): string
	{
		if (count($this->args)== 0) return ""; //empty set

		$signTestNull = false;
		$parts = array();
		foreach ($this->args as $arg) {
			$text = $compiler->compile(new SQLValue($arg, $this->type), $this->type);
			if ($text == "NULL") {
				$signTestNull = true;
				continue;
			}
			$parts[] = $text;
		}


		if (count($parts) == 0) {
			if (!$signTestNull) return (""); //empty set

			//null only
			$query = $compiler->getName($this->name) . " {$compiler->sqlDic->sqlIsNull}";
			return ($query);
		}
		//other values

		$query = "{$compiler->getName( $this->name )} {$this->mode} ";
		$query .= $compiler->sqlGroup(implode(",", $parts));

		if ($signTestNull) {
			$query .= " {$compiler->sqlDic->sqlAnd} " . $compiler->getName($this->name) . " {$compiler->sqlDic->sqlIsNull}";
		}
		return ($query);

	}
}