<?php

namespace Sigmalab\Database\Expressions;

use Sigmalab\Database\Core\DBColumnDefinition;

class ExprGTE extends ExprBool
{
	function __construct(DBColumnDefinition $name, $values)
	{
		parent::__construct(">=", $name, $values);
	}
}