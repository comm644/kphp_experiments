<?php

namespace Sigmalab\Database\Sql;

use Exception;
use ExprAND;
use ExprEQ;
use SQLExpression;

class SQLStatementDelete extends SQLStatementChange
{
	var $expr = null;

	function __construct(IDataObject $obj)
	{
		parent::__construct($obj);
		$this->sqlStatement =  "DELETE FROM";
		if (is_a($obj, 'Sigmalab\Ado\DBObjectMock')) {
			return;
		}

		if ($obj->primary_key_value() == 0 || $obj->primary_key_value() == -1) {
			return;
		}
		$this->setExpression(new ExprEQ($obj->getPrimaryKeyTag(), $obj->primary_key_value()));
	}

	/**
	 *  Set WHERE expression directly.
	 *
	 * @param $expr  IExpression object defined condition
	 * @return  IExpression  actual whichy will by applied in SQL query.
	 */
	function setExpression($expr)
	{
		$this->expr = $expr;
	}

	/**
	 * Add WHERE expression with AND clause or set expression
	 * if was empt not exists.
	 *
	 * @param $expr  IExpression object defined condition
	 * @return  IExpression  actual whichy will by applied in SQL query.
	 */
	function addExpression($expr)
	{
		if ($this->expr !== null) {
			$this->expr = new ExprAND($this->expr, $expr);
		} else {
			$this->setExpression($expr);
		}
		return $this;
	}

	function generate(SQLGenerator $generator, int $mode = 0)
	{
		if ($this->object->getTableAlias() != null) {
			throw new Exception('Aliases for SQL DELETE does not supported. Check prototype.');
		}
		$parts = array();
		$parts[] = $this->sqlStatement;

		$parts[] = SQLName::getTableName($this->table, $generator);
		if ((is_array($this->expr) && count($this->expr) != 0) || $this->expr != null) {
			$parts[] = $this->sqlWhere;
			$parts[] = SQL::compileExpr($this->expr, $generator);
		}

		return (implode(" ", $parts));
	}
}

define("CLASS_SQLStatementDelete", get_class(new SQLStatementDelete(new DBObjectMock())));
