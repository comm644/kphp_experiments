<?php

namespace Sigmalab\Database\Expressions;

use Sigmalab\Database\Core\DBColumnDefinition;

/** advanced expression
 */
class ExprRange extends ExprDummy
{
	function __construct(DBColumnDefinition $name, $min, $max)
	{
		$this->name = $name;
		parent::__construct([
			new ExprAND([
				new ExprGTE($name, $min),
				new ExprLTE($name, $max)
			])
		]);
	}
}