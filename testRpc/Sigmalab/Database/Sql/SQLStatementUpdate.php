<?php

namespace Sigmalab\Database\Sql;

use Sigmalab\Database\Core\DBValueType;
use Sigmalab\Database\Expressions\ExprAND;
use Sigmalab\Database\Expressions\ExprEQ;

class SQLStatementUpdate extends SQLStatementChange
{
	var $signForceUpdate = false;
	/**
	 * @var  IExpression[]| IExpression
	 */
	public $expr = null;


	function __construct($obj)
	{
		parent::__construct($obj);
		$this->sqlStatement = "UPDATE";
	}

	function generate(SQLGenerator $generator, int $mode = 0)
	{
		$parts = array();
		$parts[] = parent::generate($generator);
		$parts[] = $this->sqlWhere;
		$parts[] = $this->getCondition($generator);
		if ($generator->updateLimitEnabled()) {
			$parts[] = $this->sqlLimit;
			$parts[] = SQLValue::getValue(1, DBValueType::TypeInteger, $generator);
		}

		return (implode(" ", $parts));
	}

	function _generateParametrizedQuery($names, $pholders, $generator)
	{
		$parts = array();
		$parts[] = parent::_generateParametrizedQuery($names, $pholders, $generator);
		$parts[] = $this->sqlWhere;
		$parts[] = $this->getCondition($generator);

		if ($generator->updateLimitEnabled()) {
			$parts[] = $this->sqlLimit;
			$parts[] = SQLValue::getValue(1, DBValueType::TypeInteger, $generator);
		}

		return (implode(" ", $parts));
	}

	function getCondition($generator)
	{
		if ($this->expr) {
			return (SQL::compileExpr($this->expr, $generator));
		}
		$pk = $this->primaryKeys();
		$expr = array();
		foreach ($pk as $name) {
			if ($this->signEnablePK && $this->object->isChanged() && $this->object->isMemberChanged($name)) {
				$expr[] = new ExprEQ($name, $this->object->getPreviousValue($name));
			} else {
				$expr[] = new ExprEQ($name, $this->object->{$name});
			}
		}
		if (count($expr) > 1) {
			$expr = new ExprAND($expr);
		} else {
			$expr = array_shift($expr);
		}
		return (SQL::compileExpr($expr, $generator));
	}

	function _isMemberChanged(string  $name)
	{
		if ($this->signForceUpdate) return true;
		return parent::_isMemberChanged($name);
	}
}

