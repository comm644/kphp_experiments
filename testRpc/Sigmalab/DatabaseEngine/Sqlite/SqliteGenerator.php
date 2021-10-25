<?php


namespace Sigmalab\AdoDatabase\Sqlite;

use Sigmalab\Database\Core\DBValueType;
use Sigmalab\Database\Sql\SQLDic;
use Sigmalab\Database\Sql\SQLGenerator;
use Sigmalab\Database\Sql\SQLName;
use Sigmalab\Database\Sql\SQLStatement;
use Sigmalab\Database\Sql\SQLStatementInsert;

class SqliteGenerator extends SQLGenerator
{

	function __construct($dic = null)
	{
		parent::__construct($dic);
		$this->_dictionary = new SqliteDictionary();
	}

	/**
	 * returns dictionary
	 *
	 * @return SQLDic
	 */
	function getDictionary()
	{
		return $this->_dictionary;
	}

	function generateInsert(SQLStatementInsert $stm)
	{
		$tname = new SQLName($stm->table, null);

		$sql = $this->getDictionary();

		$parts = array();
		$parts[] = $stm->sqlStatement;
		$parts[] = $tname->generate($this);

		$parts[] = $sql->sqlOpenFuncParams;
		$parts[] = $stm->_getColumns($this);
		$parts[] = $sql->sqlCloseFuncParams;

		$parts[] = $sql->sqlValues;

		$parts[] = $sql->sqlOpenFuncParams;
		$parts[] = $stm->_getValues($this);
		$parts[] = $sql->sqlCloseFuncParams;

		return (implode(" ", $parts));
	}

	function generate(SQLStatement $stm) :string
	{
		switch (get_class($stm)) {
			case SQLStatementInsert::class:
				return $this->generateInsert($stm);
			default:
				return parent::generate($stm);
		}
	}

	function generateValueAsBLOB(&$value)
	{
		//mysql
		return ("X'" . bin2hex($value) . "'");
	}

	/** convert unit-time to ISO8601 format. "yyyy-MM-ddTHH:mm:ss.SSS"
	 */
	function generateDateTime($value)
	{
		$str = strftime('%Y-%m-%dT%H:%M:%S', $value);
		return $str;
	}

	/**
	 * for PDO returns same string. because PDO can escape by the way.
	 * @param string $value
	 *
	 */
	function escapeString(string $value):string
	{
		return $value;
	}

	function updateLimitEnabled()
	{
		return false;
	}

	public function generateTypeCastTo($type)
	{
		switch ($type) {
			case DBValueType::TypeInteger:
				return " as int";
			case DBValueType::TypeString:
				return " as text";
		}
		return '';
	}
}