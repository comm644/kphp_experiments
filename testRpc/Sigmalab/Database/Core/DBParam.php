<?php
namespace Sigmalab\Database\Core;

/**
 * This class describes parameter for parametrized query
 *
 * kphp-serializable
 */
class DBParam
{
	//FIXME: change DBParamType to int
	/**
	 * Common value data type. Can be 'string', 'integer', 'blob'
	 *
	 * @var int
	 * @see DBParamType_integer
	 * @see DBParamType_string
	 * @see DBParamType_lob
	 * @see DBParamType
	 *
	 * kphp-serialized-field 1
	 */
	public int $type;


	/**
	 * Paremeter name. Shoul be same as in parametrized Query.
	 *
	 * @var string
	 * kphp-serialized-field 2
	 */
	public string $name;

	/**
	 * Value which will be transmitted to query.
	 *
	 * @var mixed
	 * kphp-serialized-field 3
	 */
	public $value;


	/**
	 * Initializes new instance of DBParam
	 *
	 * @param string $name parameter name, must be same as in placeholder.
	 * @param int $type common database type for parameter, can be 'string', 'integer', 'lob'
	 * @param mixed $value
	 */
	function __construct($name, $type, $value)
	{
		$this->name = $name;
		$this->value = $value;
		$this->type = $type;
	}
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
}
