<?php

namespace Sigmalab\Database\Sql;

use Sigmalab\Database\Core\DBColumnDefinition;


class SQLGroup implements ICanGenerate
{
	public DBColumnDefinition $column;

	/**
	 * Construct SQL ORDER operator.
	 *
	 * SQL order render code by next rules:
	 *  - if $column is string - value used as column name for default table.
	 *    And renders next code:  'ORDER BY defaultTable.column'
	 *  - if $column is SQLName  - value used as fully qualified SQL Name.
	 *  - if $column is DBColumnDefinition  - value used as fully qualified column name
	 *    and will be rendered as :  ORDER BY tableName.columnName
	 *
	 *
	 * @param DBColumnDefinition $column column name
	 */
	function __construct(DBColumnDefinition $column)
	{
		$this->set($column);
	}

	function set(DBColumnDefinition $column)
	{
		$this->column = $column;
	}

	function generate(SQLGenerator $generator, ?string $defaultTable = null)
	{
		/** @var DBColumnDefinition $column */
		$column = instance_cast($this->column, DBColumnDefinition::class); //shorten val
		return SQLName::getNameFull($column->getTableAlias(), $column->name, $generator);
	}
}

