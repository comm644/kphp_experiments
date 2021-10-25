<?php

namespace Sigmalab\Database\Sql;

use Exception;
use Sigmalab\Database\Core\DBParam;
use Sigmalab\Database\Core\DBQuery;
use Sigmalab\Database\Core\IDataObject;

class SQLStatementInsertBulk extends SQLStatementChange
{
	/** enable to validate "changed" state */
	var $signUseChangedMembers = false;

	/**
	 * If user wants to insert too many object by one SQL statement.
	 *
	 * @var IDataObject[]
	 */
	public array $objectArray = [];

	function __construct($obj, $signEnablePK = false)
	{

		$dic = new SQLDic();
		$this->sqlStatement = $dic->sqlInsert;

		if (is_array($obj)) {
			$this->objectArray = $obj;
			$obj = reset($obj);
		}
		parent::__construct($obj);
		$this->signEnablePK = $signEnablePK;
	}

	function enableUseChangedMembers($sign)
	{
		$this->signUseChangedMembers = $sign;
	}

	/**
	 * @return string[]
	 */
	function primaryKeys() :array
	{
		if ($this->signEnablePK) return (array());
		return (parent::primaryKeys());
	}

	/** protected. can be overried if need disable checking for "changed"
	 */
	function _isMemberChanged(string $name)
	{
		if (!$this->signUseChangedMembers) return true; //always changed
		return $this->object->isMemberChanged($name);
	}

	/** public. genrarate SQL query
	 * @param SQLGenerator $generator
	 * @param int $mode
	 * @return string
	 */
	function generate($generator, int $mode = 0)
	{
		$sql = $generator->getDictionary();
		$tname = new SQLName($this->table, null);

		$parts = array();
		$parts[] = $this->sqlStatement;
		$parts[] = $tname->generate($generator);


		$names = $this->_getColumnsArray($generator);

		$parts[] = $sql->sqlOpenFuncParams;
		$parts[] = implode(',', $names);
		$parts[] = $sql->sqlCloseFuncParams;
		$parts[] = $sql->sqlValues;

		//FIXME: here used hack because base class  knows nothing about multiple objects for inserting.
		$values = array();
		if ($this->objectArray) {
			foreach ($this->objectArray as $obj) {
				$this->object = $obj;
				$values[] = $this->generateValues($sql, $generator);
			}
		} else {
			$values[] = $this->generateValues($sql, $generator);
		}
		$parts[] = implode(",", $values);


		return (implode(" ", $parts));
	}

	function generateValues($sql, $generator)
	{
		$values = $this->_getValuesArray($generator);

		$parts = array();
		$parts[] = $sql->sqlOpenFuncParams;
		$parts[] = implode(",\n", $values);
		$parts[] = $sql->sqlCloseFuncParams;
		return (implode(" ", $parts));
	}

	/**
	 * Generate parametrized query.
	 *
	 * @param SQLGenerator $generator
	 * @return DBQuery
	 */
	function generateQuery($generator)
	{
		if (!$generator) {
			throw new Exception("Invalid argument. 'generator' is null'");
		}
		$params = array();
		$names = array();
		$pholders = array();
		$rows = array();


		/** @var IDataObject $obj */
		foreach ($this->objectArray as $idx => $obj) {
			$pk = array($obj->primary_key());
			$defs = $obj->getColumnDefinition();

			foreach ($defs as $def) {
				if (in_array($def->name, $pk) && $this->signEnablePK == false) continue;
				//if ( !$this->_isMemberChanged( $def->name ) ) continue;
				$pholderName = $generator->generatePlaceHolderName($def->name) . '_' . $idx;
				$value = $this->object->{$def->name};

				$sqlName = new SQLName(null, $def->name);
				if ($idx == 0) {
					$names[] = $sqlName->generate($generator);
				}

				$pholders[] = $pholderName;

				$param = new DBParam(
					$pholderName,
					SQLValue::getDbParamType($value, $def->type),
					SQLValue::getDbParamValue($value, $def->type, $generator)
				);

				$params[] = $param;
			}
			$rows[] = $pholders;
			$pholders = array();
		}

		$sql = $this->_generateParametrizedQuery($names, $rows, $generator);

		return new DBQuery($sql, $params);
	}


	/**
	 * Generate parametrizedquery for specifies names and placeholders.
	 * this mehod can be overriden in inherit class for customize query generation.
	 *
	 * @param array $names sql names string array.
	 * @param array $pholders sql placeholders string array
	 * @param SQLGenerator $generator SQL generator.
	 * @return string
	 * @access protected
	 */
	function _generateParametrizedQuery($names, $pholders, $generator)
	{
		$sql = $generator->getDictionary();
		$tname = new SQLName($this->table, null);

		$parts = array();
		$parts[] = $sql->sqlInsert;
		$parts[] = $tname->generate($generator);

		$parts[] = $sql->sqlOpenFuncParams;
		$parts[] = implode(',', $names);
		$parts[] = $sql->sqlCloseFuncParams;

		$parts[] = $sql->sqlValues;


		if ($this->objectArray) {
			foreach ($pholders as $idx => $row) {
				if ($idx > 0) {
					$parts[] = ",";
				}
				$parts[] = $sql->sqlOpenFuncParams;
				$parts[] = implode(',', $row);
				$parts[] = $sql->sqlCloseFuncParams;
			}
		} else {
			$parts[] = $sql->sqlOpenFuncParams;
			$parts[] = implode(',', $pholders);
			$parts[] = $sql->sqlCloseFuncParams;
		}


		return (implode(' ', $parts));
	}

}

define("CLASS_SQLStatementInsertBulk", get_class(new SQLStatementInsertBulk(new DBObjectMock())));

