<?php

namespace Sigmalab\Database\Sql;
use Sigmalab\Database\Core\IDataObject;
use Sigmalab\Database\Expressions\ECompilerSQL;
use Sigmalab\Database\Expressions\ExprIN;
use Sigmalab\Database\Expressions\SQLExpression;
use Sigmalab\Diagnostics\Diagnostics;

class SQL
{
	function setValue($column, $value, $type = null, $sql = null)
	{
		if ($sql == null) {
			$sql = new SQLDic();
		}

		$text = SQLValue::getValue($value, $type, $sql);
		return ($sql->sqlOpenName . $column . $sql->sqlCloseName . " = $text");
	}

	function sqlIn($column, $ids_array)
	{
		$expr = new ExprIN($column, $ids_array);
		return (ECompilerSQL::s_compile($expr));
	}

	function compile($expr)
	{
		switch (strtolower(get_class($expr))) {
			case "expreq":
			case "exprneq":
			case "exprin":
			case "exprand":
			case "expror":
				return (ECompilerSQL::s_compile($expr));
			default:
				return ("");
		}
	}

	/**
	 * compile Expression
	 *
	 * @param SQLExpression|SQLExpression[] $expr expression
	 * @param SQLGenerator $generator SQL generator.
	 * @return string compiled query
	 */
	static function compileExpr($expr, $generator)
	{
		return (ECompilerSQL::s_compile($expr, $generator));
	}

	/**
	 *  Quote variable to make safe
	 *
	 * @param string $value
	 * @return string
	 */
	function quoteSmart($value)
	{
		// Stripslashes
		if (get_magic_quotes_gpc()) {
			if (is_array($value) || is_object($value)) {
				Diagnostics::error('$value should be simpletype , but got ' . gettype($value));
				return $value;
			}
			$value = stripslashes($value);
		}
		// Quote if not integer
		if (!is_numeric($value)) {
//			$value = "'" . mysql_real_escape_string($value) . "'";
			$value = "'" . $value . "'";
		}
		return $value;
	}


	/**
	 * Create select statement
	 *
	 * @param IDataObject $proto
	 * @return SQLStatementSelect
	 */
	public static function select($proto)
	{
		return new SQLStatementSelect($proto);
	}

}

