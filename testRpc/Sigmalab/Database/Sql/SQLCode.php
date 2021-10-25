<?php

namespace Sigmalab\Database\Sql;

class SQLCode implements ICanGenerateOne
{
	public string  $code;

	function __construct(string $code)
	{
		$this->code = $code;
	}

	function generate(SQLGenerator $generator, int $cause=0) : string
	{
		return ($this->code);
	}
}

