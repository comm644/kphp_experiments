<?php
/******************************************************************************
 * Copyright (c) 2007 by Alexei V. Vasilyev.  All Rights Reserved.
 * -----------------------------------------------------------------------------
 * Module     : SELECT statement
 * File       : SQLStatementSelect.php
 * Author     : Alexei V. Vasilyev
 * -----------------------------------------------------------------------------
 * Description:
 ******************************************************************************/

namespace Sigmalab\Database\Sql;

use Sigmalab\Database\Core\DBColumnDefinition;
use Sigmalab\Database\Core\DBForeignKey;
use Sigmalab\Database\Core\DBGenCause;
use Sigmalab\Database\Core\DBQuery;
use Sigmalab\Database\Core\IDataObject;
use Sigmalab\Database\Core\IDBColumnDefinition;
use Sigmalab\Database\Expressions\ECompilerSQL;
use Sigmalab\Database\Expressions\ExprAND;
use Sigmalab\Database\Expressions\IExpression;
use Sigmalab\Database\Expressions\SQLExpression;
use Sigmalab\SimpleReflection\ClassRegistry;

class SelectGeneratorMode
{
	const Normal = 0;
	const Parametrized = 1;
}

class SQLStatementSelect extends SQLStatement
{
	/** @access private section */

	var $sqlAs = "AS";
	var $sqlOrder = "ORDER BY";
	var $sqlFrom = "FROM";
	var $sqlGroup = "GROUP BY";

	var ?IExpression $expr = null;
	var $alsoTables = null;

	/** @var SQLOrder[] */
	var $order = array();

	/** @var SQLGroup[] */
	var $group = array();

	/** @var SQLJoin[] */
	var $joins = array();

	/** @var SQLLimit */
	var $limit = null;

	/** @var SQLOffset */
	var $offset = null;

	public array $queryParams =[];
	public string $querySql = "";
	public ?IExpression $having = null;

	/** Array with all prototypes used for construct statement
	 * @var IDataObject[]
	 */
	public $prototypes = array();

	/** \publicsection */


	/** construct statement
	 *
	 * @param $obj IDataObject database object prototype
	 */
	function __construct(IDataObject $obj)
	{
		parent::__construct($obj);

		$this->sqlStatement = "SELECT";
		$this->sqlWhere = "WHERE";

		$this->joins = array();
		$this->cacheKey = get_class($obj) . "\n";
		$this->cacheIt();
	}

	/** reset column information */
	function resetColumns()
	{
		$this->columnDefs = array();
		$this->cacheIt();
		return $this;
	}

	/** add column in query
	 * @param IDBColumnDefinition $def target column
	 */
	function addColumn($def)
	{
		$this->columnDefs[$def->getAliasOrName()] = $def;
		$this->cacheIt();
		return $this;
	}

	function removeColumn(DBColumnDefinition $def)
	{
		unset($this->columnDefs[$def->getAliasOrName()]);
		$this->cacheIt();
		return $this;
	}

	/** Add join by SQLJon spec
	 * @param SQLJoin $join foreign key tag
	 * @return boolean|SQLStatementSelect
	 */
	function addJoin(SQLJoin $join)
	{
		$this->cacheIt();
		if ($this->isJoined($join)) {
			return false;
		}
		$this->joins[] = $join;
		return $this;
	}

	/** add join condition specified by foreing key tag
	 * @param DBForeignKey $key
	 * @return SQLStatementSelect
	 */
	function addJoinByKey(DBForeignKey $key)
	{
		$this->cacheIt();
		$this->joins[] = SQLJoin::createByKey($key, $this->object);
		return $this;
	}

	/**
	 * add joinf expression
	 *
	 * @param SQLJoin $expr
	 */
	function addJoinExpr($expr)
	{
		$this->cacheIt();
		$this->joins[] = $expr;
		return $this;
	}

	/**
	 * Add WHERE expression with AND clause or set expression
	 * if was empt not exists.
	 *
	 * @param $expr  IExpression object defined condition
	 * @return SQLStatementSelect actual whichy will by applied in SQL query.
	 */
	function addExpression(SQLExpression $expr)
	{
		$this->cacheIt();
		if ($this->expr !== null) {
			$this->setExpression(new ExprAND([$this->expr, $expr]));
		} else {
			$this->setExpression($expr);
		}
		return $this;
	}

	/**
	 *  Set WHERE expression directly.
	 *
	 * @param $expr  IExpression object defined condition
	 * @return SQLStatementSelect
	 */
	function setExpression($expr) :self
	{
		$this->cacheIt();
		$this->expr = $expr;
		return $this;
	}

	public function getExpression()
	{
		return $this->expr;
	}


	/** add order condition
	 * @param ICanGenerateOne $column target column for order definition
	 * @param bool $ascending \a true ascending mode, else descending mode
	 * @return SQLStatementSelect
	 */
	function addOrder($column, $ascending = true)
	{
		$this->cacheIt();
		if (is_null($column)) return $this;
		if (!is_object($column) && $column == "") return $this;

		$this->addSqlOrder(new SQLOrder($column, $ascending));
		return $this;
	}

	/**
	 * Add composed SQL statement as order.
	 *
	 * @param SQLOrder $stm
	 */
	function addSqlOrder($stm)
	{
		$this->cacheIt();
		$this->order[] = $stm;
		return $this;
	}

	/** add groupping condition
	 * @param DBColumnDefinition $column target column for grouping feature
	 * @param bool $ascending \a true ascending mode, else descending mode
	 */
	function addGroup($column, $ascending = null)
	{
		$this->cacheIt();
		if (is_null($column)) return $this;
		if (!is_object($column) && $column == "") return $this;

		$this->group[] = new SQLGroup($column, $ascending);
		return $this;
	}

	/** set LIMIT feature
	 * @param integer $limit number of records for limit
	 * @return SQLStatementSelect
	 */
	function setLimit($limit)
	{
		$this->cacheIt();
		$this->limit = new SQLLimit($limit);
		return $this;
	}

	/** set OFFSET feature
	 * @param integer $offset  start offset for query
	 * @return SQLStatementSelect
	 */
	function setOffset(int $offset)
	{
		$this->cacheIt();
		$this->offset = new SQLOffset($offset);
		return $this;
	}

	/** @access private
	 * get  array of all primary keys
	 *
	 * @return string[] array of all primary keys
	 */
	function primaryKeys():array
	{
		return  [ $this->object->primary_key() ];
	}

	function conditionalGenerate(IExpression $expr, SQLGenerator $generator, int $mode=SelectGeneratorMode::Normal) :string
	{
		switch ($mode){
			case SelectGeneratorMode::Normal: return $this->generateCondition($expr, $generator);
			case SelectGeneratorMode::Parametrized: return $this->generateParametrizedCondition($expr, $generator);
		}
		return "";
	}

	/**
	 * @access protected
	 * get SQL query (only MySQL supported now )
	 * @param SQLGenerator $generator
	 * @param int $mode
	 * @return string generated SQL query
	 */
	function generate($generator, int $mode = 0)
	{
		$sql = $generator->getDictionary();

		$parts = array();
		$parts[] = $sql->sqlSelect;
		$parts[] = $this->getColumns($generator);
		$parts[] = $sql->sqlFrom;
		$parts[] = $this->_getTables($generator);

		if (count($this->joins) != 0) {
			$parts[] = $this->getJoins($generator);
		}

		if ( $this->expr ) {
			$parts[] = $sql->sqlWhere;
			$parts[] =$this->conditionalGenerate($this->expr, $generator, $mode);
		}
		if (count($this->group) != 0) {
			$parts[] = $sql->sqlGroup;
			$parts[] = $this->_getOrder($this->group, $generator);
		}
		if ($this->having) {
			$parts[] = $sql->sqlHaving;
			$parts[] = $this->conditionalGenerate($this->having, $generator, $mode);
		}

		if (count($this->order) != 0) {
			$parts[] = $sql->sqlOrder;
			$parts[] = $this->_getOrder($this->order, $generator);
		}
		if (!is_null($this->limit)) {
			$parts[] = $this->limit->generate($generator);
		}
		if (!is_null($this->offset)) {
			$parts[] = $this->offset->generate($generator);
		}
		return (implode("\n ", $parts));
	}

	function generateCondition($expr, $generator)
	{
		return SQL::compileExpr($expr, $generator);
	}

	/**
	 * Generate parametrized condition
	 *
	 * @param IExpression $expr
	 * @param SQLGenerator $generator
	 */
	function generateParametrizedCondition($expr, $generator)
	{
		$compiler = new ECompilerSQL($generator, true);
		$compiler->generationMode = DBGenCause::Where;
		$sql = $compiler->compile($expr);

		if ($this->expr) {
			$params = $compiler->getParameters();
		} else {
			$params = array();
		}
		$this->queryParams = $params;
		return $sql;
	}

	function generateQuery(SQLGenerator $generator)
	{
		if (!$this->cacheKey) {
			$this->queryParams = array();
			$sql = $this->generate($generator, SelectGeneratorMode::Parametrized);
			$this->querySql = $sql;
			return new DBQuery($sql, $this->queryParams);
		}
		//cacheKey present

		//The main problem is:
		// 1st call:  'column' IS NULL
		// 2nd call:  'column = :p0
		// solution: detect null value and don't store it.
		// solution: verify count of params


		global $__sqlStatementSelect;
		if (!isset($__sqlStatementSelect) || !$__sqlStatementSelect) {
			$__sqlStatementSelect = array();
		}
		if (isset($__sqlStatementSelect[$this->cacheKey])) {
			$this->queryParams = array();
			$this->generateParametrizedCondition($this->expr, $generator);
			$subkey = count($this->queryParams);
			$sql = $__sqlStatementSelect[$this->cacheKey . "-" . $subkey];
			$this->querySql = $sql;
			echo "cached\n";
			return new DBQuery($sql, $this->queryParams);
		}

		$this->queryParams = array();
		$sql = $this->generate($generator, SelectGeneratorMode::Parametrized);
		$this->querySql = $sql;

		$subkey = count($this->queryParams);
		$__sqlStatementSelect[$this->cacheKey . "-" . $subkey] = $sql;


		return new DBQuery($sql, $this->queryParams);
	}

	/**
	 * get joins conditions
	 * @access private
	 * @return string generated JOIN conditions
	 */
	function getJoins($generator)
	{
		$parts = array();
		/** @var SQLJoin $join */
		foreach ($this->joins as $join) {
			$parts[] = $join->generate($generator);
		}
		return (implode(" ", $parts));
	}


	/** @access private
	 * get columns for query
	 * @param SQLGenerator $generator
	 * @return string columns conditions
	 */
	function getColumns($generator)
	{
		$parts = array();
		/** @var DBColumnDefinition $def */
		foreach ($this->columnDefs as $def) {
			$str = array();
			if ($def instanceof ICanGenerateOne) {
				$str[] = $def->generate($generator, DBGenCause::Columns);
			} else {
				$str[] = $def->generate($generator, DBGenCause::Columns);
			}

			$parts[] = implode(" ", $str);
		}
		return (implode(",\n ", $parts));
	}


	/** @access private
	 * get tables for query
	 * @param SQLGenerator $generator
	 * @return string generated tables query
	 */
	function _getTables($generator)
	{
		$parts = array();
		$alias = new SQLAlias($this->object->table_name(), null, $this->object->getTableAlias());

		$parts[] = $alias->generate($generator);
//		if ($this->alsoTables) {
//			foreach ($this->alsoTables as $table) {
//				$name = new SQLName((string)$table, null);
//				$parts[] = $name->generate($generator);
//			}
//		}
		$query = implode(",", $parts);
		if (count($parts) > 1 && count($this->joins) != 0) { //MySql 5.0 requirements
			$query = "(" . $query . ")";
		}
		return ($query);
	}

	/** @access private
	 * get order  for query
	 * @param SQLGenerator $generator
	 * @param ICanGenerate[] $list target columns
	 */
	function _getOrder(array $list, SQLGenerator $generator)
	{
		if (count($list) == 0) return "";
		$parts = array();
		foreach ($list as $column) {
			$parts[] = $column->generate($generator, $this->table);
		}
		return (implode(",", $parts));
	}

	/**
	 * create default result container
	 *
	 * @param bool $signUseID set true if need use primary keys as array indexes
	 * @return SQLStatementSelectResult
	 */
	function createResultContainer($signUseID = true) : SQLStatementSelectResult
	{
		return new SQLStatementSelectResult($this, $signUseID);
	}

	/**
	 * @param mixed[] $sqlObject
	 * @return IDataObject
	 */
	function readSqlObject(array $sqlObject)
	{
		$newobj = clone $this->object;
		$refTarget = ClassRegistry::createReflection(get_class($newobj), $newobj);

		foreach ($this->columnDefs as $def) {
			$member = ($def->alias) ? $def->alias : $def->name;
			$value = SQLValue::importValue($sqlObject[$member], $def);
			$refTarget->set_as_mixed((string)$member, $value);
		}
		return $newobj;
	}

	/**
	 * @param array $sqlArray
	 * @return IDataObject
	 */
	function readSqlArray(array &$sqlArray)
	{
		$useIndex = false;
		if (is_numeric(array_first_key($sqlArray))) {
			$useIndex = true;
		}
		$newobj = clone $this->object;
		$ref = ClassRegistry::createReflection(get_class($newobj), $newobj);

		$pos = 0;
		foreach ($this->columnDefs as $idx => $def) {
			$member = $def->getAliasOrName();
			$index = $useIndex ? $pos++ : $member;
			$ref->set_as_mixed($member, SQLValue::importValue($sqlArray[$index], $def));
		}
		return $newobj;
	}

	public function isJoined(SQLJoin $anotherJoin)
	{
		/** @var SQLJoin $join */
		foreach ($this->joins as $join) {
			if ($join->ownerTag->equals($anotherJoin->ownerTag) &&
				$join->foreignTag->equals($anotherJoin->foreignTag)) {
				return true;
			}
		}
		return false;
	}

	/** Indicates whether object was joined by tag
	 * @param DBColumnDefinition $def
	 * @return bool
	 */
	public function isJoinedByTag(DBColumnDefinition $def)
	{
		foreach ($this->joins as $join) {
			if ($join->foreignTag->equals($def)) {
				return true;
			}
		}
		return false;
	}

	public function addHaving(IExpression $expr)
	{
		$this->having = $expr;
	}
}

