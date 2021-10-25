<?php

namespace Sigmalab\Database\Expressions;

use Sigmalab\Database\Core\DBColumnDefinition;

class ExprNEQ extends ExprBool
{
	function __construct(DBColumnDefinition $name, $values)
	{
		if (is_array($values)) {
			if (count($values) == 1 && is_null(reset($values))) {
				parent::__construct("IS NOT", $name, reset($values));
			} else {
				parent::__construct("!=", $name, $values);
			}
		} else if (is_null($values)) {
			parent::__construct("IS NOT", $name, $values);
		} else {
			parent::__construct("!=", $name, $values);
		}
	}
}