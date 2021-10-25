<?php

namespace Sigmalab\Database\Sql;

use Sigmalab\Diagnostics\Diagnostics;

class SQLName implements ICanGenerateOne, IColumnName
{
	public ?string $table;
	public ?string $column;

	function __construct(?string $table,?string $column)
	{
		$this->table = $table;
		$this->column = $column;
	}

	/** returns normalized escaped NAME for SQL
	 *
	 * sample:
	 * in:  table.name
	 * out: `table`.`name`
	 * @param string $name
	 * @param SQLGenerator $generator
	 * @return string
	 */
	static function getName(string $name, SQLGenerator $generator)
	{
		$sql = $generator->getDictionary();

		$pos = strpos($name, $sql->sqlTableColumnSeparator);
		if ($pos !== FALSE) {
			$table = substr($name, 0, $pos);
			$column = substr($name, $pos + 1);
			if  ($table === false ) throw new \Exception("Invalid table name");
			if  ($column === false ) throw new \Exception("Invalid column name");

			$obj = new SQLName((string)$table, $column);
		} else {
			$obj = new SQLName(null, $name);

		}
		return $obj->generate($generator);
	}

	static function getTableName(string $name, SQLGenerator $generator)
	{
		$name = new SQLName($name, null);
		return $name->generate($generator);
	}

	static function getNameFull(?string $table, ?string $column, SQLGenerator $generator)
	{
		$sql = $generator->getDictionary();

		if (!$table) return SQLName::wrap((string)$column, $sql);

		return (SQLName::wrapTableName((string)$table, $sql)
			. $sql->sqlTableColumnSeparator . SQLName::wrap((string)$column, $sql));
	}

	static function wrap(string $name, SQLDic $sql)
	{
		if (!$sql->sqlOpenName) {
			return $name;
		}
		if (strpos($name, $sql->sqlOpenName) !== FALSE) {
			Diagnostics::error('Invalid argument: $name' . "\nSQL Name cannot be given with quotes, because ADO database independed.");
			return ($name);
		}
		$name = $sql->sqlOpenName . $name . $sql->sqlCloseName;

		return ($name);
	}

	static function wrapTableName(string $name, SQLDic $sql):string
	{

		if (!$sql->sqlOpenTableName) {
			return $name;
		}
		if (strpos($name, $sql->sqlOpenTableName) !== FALSE) {
			Diagnostics::error('Invalid argument: $name' . "\nSQL Name cannot be given with quotes, because ADO database independed.");
			return ($name);
		}
		$name = $sql->sqlOpenTableName . $name . $sql->sqlCloseTableName;

		return ($name);
	}

	/**
	 * Generate SQL query.
	 *
	 * @param SQLGenerator $generator
	 * @param int $cause
	 * @return string  SQL query
	 */
	function generate(SQLGenerator $generator, int $cause=0):string
	{
		$sql = $generator->getDictionary();

		if ($this->table != null) {
			$tableName = SQLName::wrapTableName((string)$this->table, $sql);
			if ($this->column != null) {
				return $tableName . $sql->sqlTableColumnSeparator . SQLName::wrap((string)$this->column, $sql);
			}
			return $tableName;
		}
		if ($this->column != null) {
			return SQLName::wrap((string)$this->column, $sql);
		}

		return ('');
	}

	function getColumn(): ?string
	{
		return $this->column;
	}

	function getTable(): ?string
	{
		return $this->table;
	}
}
