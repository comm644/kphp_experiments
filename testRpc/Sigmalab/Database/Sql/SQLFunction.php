<?php

namespace Sigmalab\Database\Sql;
use Sigmalab\Database\Core\DBColumnDefinition;
use Sigmalab\Database\Core\DBGenCause;
use Sigmalab\Database\Core\DBValueType;
use Sigmalab\Database\Core\IDBColumnDefinition;

require_once(__DIR__ . "/SQLGenerator.php");
require_once(__DIR__ . "/../Core/DBValueType.php");

class SQLFunction implements IDBColumnDefinition
{
	public string $name;
	/**
	 * @var mixed[]
	 */
	public array $args = array();
	public ?string $alias = null;
	public string $type = 'string';
	public string $argsGlue = ', ';

	/**
	 * Create function definition
	 *
	 * @param string $functionName
	 * @param DBColumnDefinition $column
	 * @param string $type result type DBValueType
	 * @param string $alias column alias
	 * @return SQLFunction  created object
	 */
	static function create(string $functionName, DBColumnDefinition $column, string $type, ?string $alias = null)
	{
		if (is_null($alias)) {
			if (is_string($column)) $alias = $column;
			else $alias = null;
		}
		$obj = new SQLFunction;
		$obj->name = $functionName;
		$obj->args[] = $column;
		$obj->alias = $alias;
		$obj->type = $type;

		return ($obj);
	}

	function getAlias()
	{
		if ($this->alias == null) return ($this->name);
		return ((string)$this->alias);
	}

	function getAliasOrName()
	{
		return $this->getAlias();
	}

	/**
	 * create function 'count'
	 *
	 * @param DBColumnDefinition|SQLName|string $column
	 * @param string $alias (null if not set)
	 * @return SQLFunction
	 */
	static function count($column, $alias = null)
	{
		return (SQLFunction::create("count", $column, null, $alias));
	}

	/**
	 * @param IDBColumnDefinition|SQLName|string $column
	 * @param string|null $alias
	 * @param null $type
	 * @return SQLFunction
	 */
	static function max($column, $alias = null, $type = null)
	{
		if (is_null($type)) {
			if ($column instanceof DBColumnDefinition) {
				$type = $column->getType();
			} else {
				$type = DBValueType::TypeInteger;
			}
		}
		return (SQLFunction::create("max", $column, $type, $alias));
	}

	static function min($column, $alias = null, $type = DBValueType::TypeFloat)
	{
		return (SQLFunction::create("min", $column, $type, $alias));
	}

	static function sum($column, $alias = null, $type = DBValueType::TypeFloat)
	{
		return (SQLFunction::create("sum", $column, $type, $alias));
	}

	/** Generate CAST expression
	 * @param DBColumnDefinition|SQLFunction $column
	 * @param string $type DBValueType enum
	 * @return SQLFunction
	 */
	static function cast($column, $type)
	{
		return self::create("", $column, $type);
	}

	static function custom($name, array $args, $alias = null, $type = null)
	{
		$columnName = null;
		$func = SQLFunction::create($name, $columnName, $type, $alias);
		$func->args = $args;
		$func->argsGlue = ', ';
		return ($func);
	}

	/**
	 * Generate SQL query.
	 *
	 * @param SQLGenerator $generator
	 * @param int $cause
	 * @return string  SQL query
	 */
	function generate(SQLGenerator $generator, int $cause=0) :string
	{
		$sql = $generator->getDictionary();

		$parts = array();

		$isCast = $generator->generateTypeCastTo($this->type);

		$parts[] = $this->name . $sql->sqlOpenFuncParams;
		$pos = 0;
		if ($isCast) {
			$parts[] = $sql->sqlCast;
			$parts[] = $sql->sqlOpenFuncParams;
		}

		foreach ($this->args as $arg) {
			if ($pos > 0) $parts[] = $this->argsGlue;
			if ( (object)$arg instanceof ICanGenerateOne) {
				$parts[] = $generator->generateColumn(instance_cast($arg, ICanGenerateOne::class), $this->getTableAlias());
			}
			else {
				throw new \Exception("Invalid argument type in SQLFunction (no an instance of ICanGenerateOne");
			}
			$pos++;
		}
		if ($isCast) {
			$parts[] = $generator->generateTypeCastTo($this->type);
			$parts[] = $sql->sqlCloseFuncParams;
		}

		$parts[] = $sql->sqlCloseFuncParams;


		$alias = $this->alias;
		$column = $this->args[0];
		if (!$alias && $column instanceof IDBColumnDefinition && $cause == DBGenCause::Columns) {
			$col = instance_cast($column, IDBColumnDefinition::class);
			//only for COLUMNS
			$alias = $col->getName();
		}
		if ($alias) {

			$parts[] = $sql->sqlAs;
			$parts[] = $generator->generateName(new SQLName(null, $alias));
		}
		return (implode(" ", $parts));
	}

	/**
	 * Gets column name. Methods retuns raw column name.
	 *
	 * @return string
	 */
	public function getName()
	{
		return $this->getAliasOrName();
	}

	/**
	 * Gets table alias.
	 * Method returns table alias if alias defined. If table alias is not defined
	 * then method returns table name.
	 *
	 * If table not defined for column then method returns null
	 *
	 * @return string|null ?string  table alias
	 */
	function getTableAlias():?string
	{
		$tableName = $this->getTableName();
		if (!$tableName) return "";
		return (string)$tableName;
	}

	/**
	 * Gets raw table name.
	 *
	 * @return ?string
	 */
	function getTableName():?string
	{
		return null;
	}

	public function equals(DBColumnDefinition $tag)
	{
		return false;
	}

	/**
	 * @inheritDoc
	 */
	public function isNullable()
	{
		return false;
	}

	/**
	 * @inheritDoc
	 */
	public function getType()
	{
		return $this->type;
	}
}
