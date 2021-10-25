<?php

namespace Sigmalab\Database\Sql;


class SQLParam
{
	/**
	 * @var mixed
	 */
	public $value;

	function __construct($value)
	{
		$this->value = $value;
	}

	/** protected. generate quiery accoring to keyword and saved value
	 */
	function _generate($statement)
	{
		$parts = array();
		$parts[] = $statement;
		$parts[] = (string)$this->value;
		return (implode(" ", $parts));
	}

}


