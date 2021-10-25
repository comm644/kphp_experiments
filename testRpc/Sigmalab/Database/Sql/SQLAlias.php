<?php

namespace Sigmalab\Database\Sql;

/**
 * SQL:  AS  keyword.
 *
 *  example:   table.column AS alias
 */
class SQLAlias
{
	var $table;
	var $column;
	var $alias;

	function __construct($table, $column, $alias)
	{
		$this->table = $table;
		$this->column = $column;
		$this->alias = $alias;
	}

	function generate(SQLGenerator $generator)
	{
		$parts = array();
		$sql = $generator->getDictionary();

		if ($this->table) {
			$parts[] = SQLName::getTableName((string)$this->table, $generator);
		}
		if ($this->column != null) {
			$parts[] = $sql->sqlTableColumnSeparator;
			$parts[] = SQLName::getName((string)$this->column, $generator);
		}
		if ($this->alias) {
			$parts[] = $sql->sqlAs;
			$parts[] = SQLName::getTableName($this->alias, $generator);
		}
		return (implode(" ", $parts));
	}

	function generateAlias($generator)
	{
		if ($this->alias) $name = $this->alias;
		else if ($this->column) $name = $this->column;
		else $name = $this->table;
		return (SQLName::getName($name, $generator));


	}
}
