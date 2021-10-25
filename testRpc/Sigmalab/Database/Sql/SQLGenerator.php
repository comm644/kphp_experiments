<?php


namespace Sigmalab\Database\Sql;

use Sigmalab\Database\Core\DBGenCause;
use Sigmalab\Database\Core\DBQuery;

abstract class SQLGenerator
{
	/**
	 * SQL dictionary
	 *
	 * @var SQLDic
	 */
	protected $_dictionary;

	/** construct generator
	 * @param SQLDic $dictionary
	 */
	function __construct(?SQLDic $dictionary = null)
	{
		if ($dictionary) $dictionary = new SQLDic();

		$this->_dictionary = $dictionary;
	}

	/**
	 * Get SQL dictionary.
	 *
	 * @return SQLDic
	 */
	function getDictionary()
	{
		return $this->_dictionary;
	}

	/** generate sql column defintion from mixed variable
	 *
	 * @param ICanGenerateOne $column
	 * @param string|null $defaultTable default name.
	 */
	function generateColumn(ICanGenerateOne $column, ?string $defaultTable = null)
	{
		return $column->generate($this, DBGenCause::Columns);
	}

	/**
	 * @param ICanGenerateOne $column
	 * @return string
	 */
	function generateName(ICanGenerateOne $column)
	{
		return $column->generate($this);
	}

	function generateValueAsBLOB(&$value)
	{
		//mysql
		return ("0x" . bin2hex($value));
	}

	/**
	 * Generate place holder name.
	 *
	 * @param string $name base name
	 * @return string  real place holder name
	 */
	function generatePlaceHolderName($name)
	{
		return ':' . $name;
	}


	/**
	 * Generate statement SQL query
	 * @param \Sigmalab\Database\Sql\SQLStatement $stm
	 * @return string
	 */
	function generate(SQLStatement $stm) :string
	{
		return $stm->generate($this);
	}

	/**
	 * Generate parametrized query.
	 * Use this method for insert and update opration bacause BLOBs via parameter have better transfer speed.
	 * returns   rendred query object
	 *
	 * @param SQLStatement $stm
	 *
	 * @return DBQuery
	 */
	function generateParametrizedQuery(SQLStatement $stm) : DBQuery
	{
		return $stm->generateQuery($this);
	}

	/**
	 * Generate SQL DateTime value
	 * @param integer $value unix time
	 * @return string  SQL92 Date time
	 */
	function generateDateTime(int $value)
	{
		return (strftime("%Y-%m-%d %H:%M:%S", $value));
	}

	/**
	 * Generate SQL Date value
	 * @param integer $value unix time
	 * @return string  SQL92 Date time
	 */
	function generateDate(int $value) :string
	{
		return (strftime("%Y-%m-%d", $value));
	}

	/**
	 * Escape string for using in non-compileable SQL requestes.
	 * for PDO implement as dummy method.
	 *
	 * @param string $value
	 * @return string   escaped string.
	 */
	public abstract function escapeString(string $value) :string;

	/**
	 * Generarte LIKE condition
	 *
	 * @param string $name column name
	 * @param string $value value string without 'any string' instructions
	 * @return string constructed expression
	 */
	function generateLikeCondition($name, $value)
	{
		$value = $this->escapeString($value);
		return ("{$name} LIKE '%{$value}%'");
	}

	/**
	 * Generate search string. escape string if need and wrap to '%' or
	 * another according to database
	 *
	 * @param string $value
	 * @return string
	 */
	function generateSearchString($value)
	{
		$value = $this->escapeString($value);
		return ("%" . $value . "%");
	}

	/** some databases does not have support LIMIT for UPDATE Statement.
	 */
	function updateLimitEnabled()
	{
		return true;
	}

	public function generateTypeCastTo($type)
	{
		return '';
	}
}

?>