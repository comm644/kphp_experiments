<?php

/* * ****************************************************************************
  Copyright (c) 2005 by Alexei V. Vasilyev.  All Rights Reserved.
  -----------------------------------------------------------------------------
  Module     : SQL Value converter
  File       : SQLValue.php
  Author     : Alexei V. Vasilyev
  -----------------------------------------------------------------------------
  Description:

  require: DataSource global defined class
 * **************************************************************************** */

namespace Sigmalab\Database\Sql;

use Sigmalab\Database\Core\DBParamType;
use Sigmalab\Database\Core\IDBColumnDefinition;
use Sigmalab\Database\Expressions\IExpression;
use Sigmalab\Diagnostics\Diagnostics;


class SQLValue implements IExpression
{

	/**
	 * value
	 *
	 * @var mixed
	 */
	var $value;

	/**
	 * internal SQL type for values
	 *
	 * @var string
	 */
	var $type;

	/**
	 * construct SQL value container
	 *
	 * @param mixed $value
	 * @param string|null $type
	 */
	function __construct($value, ?string $type = null)
	{
		$this->value = $value;

		if (is_null($type)) {
			$this->type = gettype($value);
		}
		else {
			$this->type = (string)$type;
		}
	}

	function generate($generator)
	{
		return self::getValue($this->value, $this->type, $generator);
	}

	/**
	 *  Present value as string for using in SQL query.
	 *
	 * @param string $value
	 * @param SQLGenerator $generator
	 */
	static function getAsString(string $value, SQLGenerator $generator)
	{
		return implode("", array(
			$generator->getDictionary()->sqlStringOpen,
			$generator->escapeString($value),
			$generator->getDictionary()->sqlStringClose));
	}

	static function getAsBLOB(&$value, SQLGenerator $generator)
	{
		return $generator->generateValueAsBLOB($value);
	}

	static function getAsInt(&$value)
	{
		//process foreign-keys
		if ($value === "")
			return (SQLValue::getAsNull($value));
		if ($value === null)
			return (SQLValue::getAsNull($value));
		return (sprintf("%d", $value));
	}

	private static function getAsFloat($value)
	{
		if ($value === "")
			return (SQLValue::getAsNull($value));
		if ($value === null)
			return (SQLValue::getAsNull($value));

		return sprintf("%3.10f", $value);
	}


	/**
	 * @param mixed $value
	 * @param \Sigmalab\Database\Sql\SQLGenerator $generator
	 * @return string
	 */
	static function getAsDatetime($value, SQLGenerator $generator):string
	{
		if (is_string($value))
			return (sprintf("'%s'", $value));
		return (sprintf("'%s'", $generator->generateDateTime((int)$value)));
	}

	/**
	 * @param mixed $value
	 * @param \Sigmalab\Database\Sql\SQLGenerator $generator
	 * @return string
	 */
	static function getAsDate($value, SQLGenerator $generator)
	{
		if (is_string($value))
			return (sprintf("'%s'", $value));
		return (sprintf("'%s'", $generator->generateDate((int)$value)));
	}

	static function fromSqlDateTime($value)
	{
		if (!$value) {
			return null;
		}
		$parts = preg_split("/[ T\.\-:]/", $value);
		if (count($parts) < 6) {
			Diagnostics::warning("not expected SQL datetime: $value");
		}
		list($year, $month, $day, $hour, $min, $sec) = $parts;
		$result = mktime(
			intval($hour), intval($min), intval($sec), intval($month), intval($day), intval($year));
		return $result;
	}

	static function fromSqlDate($value)
	{
		if (!$value) {
			return null;
		}
		$parts = preg_split("/[ T\.\-]/", $value);
		if (count($parts) < 3) {
			Diagnostics::warning("not expected SQL date: $value");
		}
		list($year, $month, $day) = $parts;
		$result = mktime(
			null, null, null, intval($month), intval($day), intval($year));
		return $result;
	}

	static function getAsNull(&$value)
	{
		return ("NULL");
	}

	/** returns SQL value with conversion according to Type Definition
	 * @param mixed $value
	 * @param string $type
	 * @param SQLGenerator $generator
	 * @return string
	 */
	static function getValue($value, string $type, SQLGenerator $generator)
	{
		if (is_null($value))
			return ("NULL");

		if (!$type)
			$type = gettype($value);

		switch ($type) {
			default:
			case "enum":
			case "text":
			case "string":
				return (SQLValue::getAsString((string)$value, $generator));
				break;

			case "longblob":
			case "tinyblob":
			case "mediumblob":
			case "blob":
				return (SQLValue::getAsBLOB($value, $generator));
				break;
			case "int":
			case "integer":
				return (SQLValue::getAsInt($value));
				break;
			case "double":
			case "float":
				return (SQLValue::getAsFloat($value));
				break;
			case "date":
				return (SQLValue::getAsDate($value, $generator));
				break;
			case "datetime":
				return (SQLValue::getAsDatetime($value, $generator));
				break;
		}
	}

	/** returns DBParamType  for specified  Type Definition
	 *
	 * @param mixed $value value for parameter, required for NULL detection.
	 * @param string|null $type DbType  defined in DBObject/DBColumnDefinition
	 * @return int
	 */
	static function getDbParamType($value, ?string $type = null) :int
	{
		if (is_null($value)) {
			return (DBParamType::Null);
		}

		if (is_null($type)) {
			$type = gettype($value);
		}

		switch ($type) {
			default:
			case "enum":
			case "date":
			case "datetime":
			case "string":
				return (DBParamType::String);

			case "bool":
			case "boolean":
				return DBParamType::Bool;

			case "tinyint":
			case "smallint":
			case "biglint":
			case "mediumint":
			case "int":
			case "integer":
				return (DBParamType::Integer);

			case "double":
			case "float":
				return DBParamType::Real;


			case "longblob":
			case "tinyblob":
			case "mediumblob":
			case "blob":
				return (DBParamType_lob);
		}
	}

	/** get value according to type and database engine.
	 * @param $value
	 * @param string|null $type
	 * @param SQLGenerator $generator
	 * @return mixed
	 */
	static function getDbParamValue($value, ?string $type, SQLGenerator $generator)
	{
		if (is_null($value))
			return (NULL);
		if (is_null($type))
			$type = gettype($value);

		switch ($type) {
			case "datetime":
				if (is_string($value)) return ($value);
				return ($generator->generateDateTime((int)$value));

			case "date":
				if (is_string($value)) return ($value);
				return ($generator->generateDate((int)$value));

			default:
				return $value;
		}
	}

	static function importValue($value, IDBColumnDefinition $def)
	{
		if ($def->isNullable() && $value === null) {
			return null;
		}
		$type = $def->getType();

		switch ($type) {
			case "datetime":
				if ($value === null) return null;
				return (SQLValue::fromSqlDateTime($value));

			case "date":
				if ($value === null) return null;
				return (SQLValue::fromSqlDate($value));

			case "tinyint":
			case "smallint":
			case "bigint":
			case "mediumint":
			case "int":
			case "integer":
				return (intval($value));
				break;

			case "double":
			case "float":
			case "real":
				return floatval($value);

			case "string":
			case "varchar":
			case "text":
				if ($value === null) return "";
				return $value;

			default:
				return $value;
		}
	}

}
