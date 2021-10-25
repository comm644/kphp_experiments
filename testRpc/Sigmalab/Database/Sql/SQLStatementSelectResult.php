<?php

namespace Sigmalab\Database\Sql;

use Sigmalab\Database\Core\DBResultContainer;
use Sigmalab\Database\Core\IDataObject;


/**result container for working with SQLStatementSelect
 */
class SQLStatementSelectResult extends DBResultContainer
{
	/**
	 * Owner statement
	 *
	 * @var SQLStatementSelect
	 */
	protected $stm;
	protected $signUseID;


	function __construct($stm, $signUseID)
	{

		$this->stm = $stm;
		$this->signUseID = $signUseID;
	}

	/**
	 * @param array|mixed[] $row
	 * @return IDataObject
	 */
	function fromSQL(array $row) :IDataObject
	{
		if (is_array($row)) {
			return $this->stm->readSqlArray($row);
		} else {
			return $this->stm->readSqlObject($row);
		}
	}

	/**
	 * Add row as object to result.
	 *
	 * @param IDataObject $object
	 */
	function add(IDataObject $object)
	{
		if ($this->signUseID == true) {
			$pos = $this->getKey($object);
			$this->data[$pos] = $object;
		} else {
			$this->data[] = $object;
		}
	}

	function getKey(IDataObject $obj)
	{
		return $obj->primary_key_value();
	}

	/**
	 * @return SQLStatementSelect
	 */
	public function getStatement(): SQLStatementSelect
	{
		return $this->stm;
	}

	public function parseResult(array $sqlRows)
	{
		$this->begin();;
		foreach ($sqlRows as $sqlRow) {
			$this->add( $this->fromSQL((array)$sqlRow) );
		}

		$this->end();;
	}
}


