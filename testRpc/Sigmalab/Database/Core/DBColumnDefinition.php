<?php

namespace Sigmalab\Database\Core;

use Sigmalab\Database\Expressions\IExpression;
use Sigmalab\Database\Sql\IColumnName;
use Sigmalab\Database\Sql\SQLGenerator;
use Sigmalab\Database\Sql\SQLName;
use Sigmalab\SimpleReflection\IReflectedObject;

/**
 * This class defines meta information about database column.
 *
 * Usually in generated code this class used as return value in tag_*() methods.
 */
class DBColumnDefinition implements IDBColumnDefinition,
	IReflectedObject,
	IColumnName,
	IExpression
{
	public string $name;
	public ?string $type;
	public ?string $alias = null;
	public string $description = "";

	/** @var IDataObject */
	public ?IDataObject $table;
	public $disableGetByReference = false;
	private $isNullable = true;
	public $isAggregate = false;

	/**
	 * @var string
	 */

	function __construct(string $name = "unknown", ?string $type = null, ?string $alias = null, ?IDataObject $table = null, $disableGetByReference = false, $description = "", $isNullable = true)
	{
		$this->name = $name;
		$this->type = $type;
		$this->description = $description;
		$this->isNullable = $isNullable;


		if ($alias != null) {
			$this->alias = $alias;
		} else {
			//Sqlite returns full column name if join ('table.column' instead 'column' )
			$this->alias = $name;
		}
		$this->table = $table;
		$this->disableGetByReference = $disableGetByReference;
	}

	/**
	 * Gets column name. Methods retuns raw column name.
	 *
	 * @return string
	 */
	public function getName()
	{
		return $this->name ? (string)$this->name : "";
	}


	/**
	 * Gets column alias if defined.
	 * If column alias is not defined then method returns column name.
	 *
	 * @return string
	 */
	function getAlias()
	{
		return $this->alias ? (string)$this->alias : "";
	}


	/**
	 * Gets alias or name for binding destination column name.
	 * Main idea is : value in result set can be binded to another member.
	 * member name in this case need set by Alias, another words, column name
	 * always have using as member name.
	 *
	 * @return string
	 */
	function getAliasOrName()
	{
		if (!$this->alias) {
			return (string)$this->name;
		}
		return (string)$this->alias;
	}

	/**
	 * Gets table alias.
	 * Method returns table alias if alias defined. If table alias is not defined
	 * then method returns table name.
	 *
	 * If table not defined for column then method returns null
	 *
	 * @return ?string  table alias
	 */
	function getTableAlias(): ?string
	{
		if (!$this->table) return (null);

		$alias = $this->table->getTableAlias();
		if (!$alias) $alias = $this->table->table_name();
		return ($alias);
	}


	/**
	 * @inheritDoc
	 */
	function getTableName(): ?string
	{
		if (!$this->table) return (null);
		return ($this->table->table_name());
	}

	public function equals(DBColumnDefinition $tag)
	{
		if ($this->getAliasOrName() != $tag->getAliasOrName()) return false;
		if ($this->getTableAlias() != $tag->getTableAlias()) return false;
		return true;
	}

	/**
	 * @param SQLGenerator $generator
	 * @param int $cause
	 * @return string
	 */
	public function generate(SQLGenerator $generator, int $cause = 0): string
	{
		$sql = $generator->getDictionary();

		if ($cause == DBGenCause::Order) {
			return SQLName::getNameFull($this->getTableAlias(), $this->getName(), $generator);
		}
		if ($cause == DBGenCause::Group) {
			return SQLName::getNameFull($this->getTableAlias(), $this->getName(), $generator);
		}
		if ($cause == DBGenCause::Where) {
			return SQLName::getNameFull($this->getTableAlias(), $this->getName(), $generator);
		}

		$str = array();
		$table = $this->getTableAlias();
		$str[] = SQLName::getNameFull($table, $this->name, $generator);

		if ($this->alias) {
			$str[] = $sql->sqlAs;
			$str[] = SQLName::getName((string)$this->alias, $generator);
		}
		return implode(" ", $str);
	}

	public function getType()
	{
		return (string)$this->type;
	}

	function __toString()
	{
		return "{$this->getTableName()} : {$this->getName()} as {$this->getAlias()}}";
	}

	function isNullable()
	{
		return $this->isNullable;
	}

	function getColumn(): ?string
	{
		return $this->name;
	}

	function getTable(): ?string
	{
		return $this->getAliasOrName();
	}
}

