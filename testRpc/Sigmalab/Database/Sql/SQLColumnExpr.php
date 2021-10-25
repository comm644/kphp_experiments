<?php

namespace Sigmalab\Database\Sql;
use Sigmalab\Database\Core\DBColumnDefinition;
use Sigmalab\Database\Core\IDBColumnDefinition;
use Sigmalab\Database\Expressions\ECompilerSQL;
use Sigmalab\Database\Expressions\SQLExpression;

define("CLASS_ExprCast", get_class(new ExprCast(null, null)));

/**
 * This class provides column as result of calculatons.
 * You can use Expr* object as argument.
 */
class SQLColumnExpr implements IDBColumnDefinition
{
	/** @var SQLExpression */
	public  IExpression $expr;

	public ?string $alias;

	/**
	 * @var string
	 */
	public string $type;

	function __construct( IExpression $expr, ?string $alias = null, string $type = "string")
	{
		$this->expr = $expr;
		$this->alias = $alias;
		$this->type = $type;
	}

	function getAlias()
	{
		return ($this->alias);
	}

	function getAliasOrName()
	{
		return $this->getAlias();
	}

	/**
	 * Generate SQL query.
	 *
	 * @param SQLGenerator $generator
	 * @param int $cause
	 * @return string  SQL query
	 */
	function generate(SQLGenerator $generator, int $cause=0):string
	{
		$sql = $generator->getDictionary();

		$parts = array();

		$parts[] = ECompilerSQL::s_compile($this->expr, $generator);

		if ($this->alias) {
			$parts[] = $sql->sqlAs;
			$parts[] = $generator->generateName(new SQLName(null, $this->alias));
		}
		return (implode(" ", $parts));
	}

	/**
	 * Gets column name. Methods retuns raw column name.
	 *
	 * @return string
	 */
	public function getName()
	{
		return null;
	}

	/**
	 * Gets table alias.
	 * Method returns table alias if alias defined. If table alias is not defined
	 * then method returns table name.
	 *
	 * If table not defined for column then method returns null
	 *
	 * @return string  table alias
	 */
	function getTableAlias()
	{
		return $this->getTableName();
	}

	/**
	 * Gets raw table name.
	 *
	 * @return ?string
	 */
	function getTableName():?string
	{
		return null;
	}

	public function equals(DBColumnDefinition $tag)
	{
		return false;
	}

	/**
	 * @inheritDoc
	 */
	public function isNullable()
	{
		return false;
	}

	/**
	 * @inheritDoc
	 */
	public function getType()
	{
		return $this->type;
	}
}


