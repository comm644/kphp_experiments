<?php


namespace Sigmalab\Database\Core;
/**
 * This class incapsulates parametrized SQL query and paremeters which
 * can be assigned to query placeholders.
 *
 */
class DBQuery
{
	/**
	 * Generated query with placeholders.
	 *
	 * @var string
	 * @access private
	 */
	var $_query;

	/**
	 * Parameters array for query.
	 *
	 * @var array
	 * @access private
	 */
	var $_params;

#ifndef KPHP
	public static function __set_state($array)
	{
		$obj = new DBQuery('', array());
		foreach ($array as $key => $value) {
			$obj->$key = $value;
		}
		return $obj;
	}
#endif

	/**
	 * Gets query with placeholders.
	 *
	 * @return string
	 */
	function getQuery()
	{
		return $this->_query;
	}

	/**
	 * Gets parameters array
	 *
	 * @return array array of DBParam
	 * @see DBParam
	 */
	function getParameters()
	{
		return $this->_params;
	}

	/**
	 * Initializes new instance of DBQuery object.
	 *
	 * @param string $sqlQuery generated SQL parametrized query.
	 * @param array $parameters DBParam array.
	 */
	function __construct($sqlQuery, $parameters)
	{
		$this->_query = $sqlQuery;
		$this->_params = $parameters;
	}
}

