<?php

namespace Sigmalab\DatabaseEngine\Gate;
use Sigmalab\Database\Core\DBParam;

/**
 * This class describes parameter for parametrized query
 *
 * @kphp-serializable
 */
class SqlQueryParam
{
	/**
	 * Common value data type. Can be 'string', 'integer', 'blob'
	 *
	 * @var int
	 * @see DBParamType_integer
	 * @see DBParamType_string
	 * @see DBParamType_lob
	 *
	 * @kphp-serialized-field 1
	 */
	public int $type;

	/**
	 * Paremeter name. Shoul be same as in parametrized Query.
	 *
	 * @var string
	 * @kphp-serialized-field 2
	 */
	public string $name;

	/**
	 * Value which will be transmitted to query.
	 *
	 * @var mixed
	 * @kphp-serialized-field 3
	 */
	public $value;


	/**
	 * Initializes new instance of DBParam
	 *
	 * @param string $name parameter name, must be same as in placeholder.
	 * @param int $type common database type for parameter, can be 'string', 'integer', 'lob'
	 * @param mixed $value
	 */
	function __construct(string $name, int $type, $value)
	{
		$this->name = $name;
		$this->value = $value;
		$this->type = $type;
	}

	/**
	 * @param DBParam $param
	 * @return SqlQueryParam
	 * @kphp-inline
	 */
	static function mkParam(DBParam $param)
	{
		return new SqlQueryParam($param->name, $param->type, $param->value);
	}
}