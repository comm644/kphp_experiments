<?php

namespace Sigmalab\Database\Sql;

use Sigmalab\Database\Core\DBGenCause;

/**
 * SQL:  'ORDER BY'  construction
 *
 */
class SQLOrder implements ICanGenerate
{
	/** @var  ICanGenerateOne */
	public ICanGenerateOne $column;
	public bool $ascending = true;

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
	 * @param ICanGenerateOne $column column name
	 * @param bool $ascending ascending flag. Order ascending if true. Otherwise order sets as descending.
	 */
	function __construct(ICanGenerateOne $column, $ascending = true)
	{
		$this->set($column, $ascending);
	}

	function set($column, $ascending = true)
	{
		$this->column = $column;
		$this->ascending = $ascending;
	}

	function generate(SQLGenerator $generator, ?string $defaultTable = null)
	{
		$sql = new SQLDic();
		if (!$this->column) return "";

		$parts = array(
			$this->column->generate($generator, DBGenCause::Order),
			$this->ascending ? $sql->sqlAscending : $sql->sqlDescending
		);
		return (implode(" ", $parts));
	}
}

