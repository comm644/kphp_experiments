<?php

namespace Sigmalab\Database\Sql;

use Sigmalab\Database\Core\DBColumnDefinition;
use Sigmalab\Database\Core\IDataObject;


abstract class SQLStatement
{
	public string $sqlStatement = "--- undefined --";
	public string $sqlWhere = "WHERE";
	public string $sqlLimit = "LIMIT";

	/**
	 * Object with metainformation for creating default statement.
	 *
	 * @var IDataObject
	 */
	public IDataObject $object;

	/**
	 * Columns for selection
	 * @var DBColumnDefinition[]
	 */
	public array $columnDefs = [];
	public ?string $table = null;

	public bool $isDebug = false;
	public string $cacheKey = "";

	function __construct(IDataObject $obj)
	{
		$this->object = $obj;
		$this->columnDefs = array();
		foreach ($this->object->getColumnDefinition() as $def) {
			$this->columnDefs[$def->getAliasOrName()] = $def;
		};
		$this->table = $this->object->table_name();

	}

	/**
	 * @return string[]
	 */
	function primaryKeys()  :array
	{
		/** @var string[] $pk */
		$pk = [ $this->object->primary_key() ];
		return ($pk);
	}

	public function setDebug($sign)
	{
		$this->isDebug = $sign;
		return $this;
	}

	public function cacheIt()
	{
#ifndef KPHP
		$bt = @debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 3);
		$this->cacheKey .= $bt[1]["file"] . ':' . $bt[1]["line"] . "->\n";
		$this->cacheKey .= @$bt[2]["file"] . ':' . @$bt[2]["line"] . "\n";
#endif
		//echo "cachekey: ".$this->cacheKey ."\n";
	}

	function generateQuery(SQLGenerator $generator)
	{
		return null;
	}

	/**
	 * @param SQLGenerator $generator
	 * @param int $mode
	 * @return string
	 * @throws \Exception
	 */
	abstract function generate(SQLGenerator $generator, int $mode = 0);
}



