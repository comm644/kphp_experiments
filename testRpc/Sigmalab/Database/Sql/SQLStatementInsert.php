<?php

namespace Sigmalab\Database\Sql;

use Sigmalab\Database\Core\IDataObject;

class SQLStatementInsert extends SQLStatementChange
{

	/** enable to validate "changed" state */
	var $signUseChangedMembers = false;

	/**
	 * If user wants to insert too many object by one SQL statement.
	 *
	 * @var IDataObject|IDataObject[]
	 */
	public array $objectArray = [];

	function __construct(IDataObject $obj, $signEnablePK = false)
	{
		$dic = new SQLDic();
		$this->sqlStatement = $dic->sqlInsert;

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

	/** public. generate SQL query
	 * @param SQLGenerator $generator
	 * @param int $mode
	 * @return string
	 */
	function generate(SQLGenerator $generator, int $mode = 0)
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
		if (count($this->objectArray)) {
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

	function generateValues(SQLDic $sql, SQLGenerator $generator)
	{
		$values = $this->_getValuesArray($generator);

		$parts = array();
		$parts[] = $sql->sqlOpenFuncParams;
		$parts[] = implode(",\n", $values);
		$parts[] = $sql->sqlCloseFuncParams;
		return (implode(" ", $parts));
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

		$parts[] = $sql->sqlOpenFuncParams;
		$parts[] = implode(',', $pholders);
		$parts[] = $sql->sqlCloseFuncParams;

		return (implode(' ', $parts));
	}

}


