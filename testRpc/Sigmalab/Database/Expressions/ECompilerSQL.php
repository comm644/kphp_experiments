<?php

namespace Sigmalab\Database\Expressions;

use Exception;
use Sigmalab\Database\Core\DBColumnDefinition;
use Sigmalab\Database\Core\DBGenCause;
use Sigmalab\Database\Core\DBParam;
use Sigmalab\Database\Sql\ICanGenerateOne;
use Sigmalab\Database\Sql\SQLDic;
use Sigmalab\Database\Sql\SQLGenerator;
use Sigmalab\Database\Sql\SQLName;
use Sigmalab\Database\Sql\SQLValue;

class ECompilerSQL
{
	const EMPTY = "";
	/**
	 * SQL dictionary
	 *
	 * @var SQLDic
	 */
	var $sqlDic = null;


	/**
	 * SQL Geenrator instance
	 *
	 * @var SQLGenerator
	 */
	var $generator = null;


	/**
	 * Indicates wheter method compile() returns parametrized query.
	 *
	 * @var bool
	 */
	var $isParametrized = false;

	/**
	 * Param index for constructing name
	 *
	 * @var integer
	 */
	var $paramIndex = 0;

	/**
	 *  Array of constructed params
	 * @var DBParam[]
	 */
	var $params = array();
	/**
	 * @var int
	 */
	public int $generationMode = DBGenCause::Columns;

	/**
	 * Initialize new copy of ECompilerSQL
	 *
	 * @param SQLGenerator $generator
	 */
	function __construct($generator, $isParametrized = false)
	{
		$this->sqlDic = $generator->getDictionary();
		$this->generator = $generator;
		$this->isParametrized = $isParametrized;
	}

	/**
	 * Gets compiled parameters
	 * @return array(DBParam)
	 */
	public function getParameters()
	{
		return $this->params;
	}


	/**
	 * group expressions
	 *
	 * @param string $query
	 * @return string
	 */
	function sqlGroup($query)
	{
		return "({$query})";
	}

	public static function s_sqlGroup(string $query)
	{
		return "({$query})";
	}


	function createParamName()
	{
		$name = $this->generator->generatePlaceHolderName('p' . $this->paramIndex);
		$this->paramIndex++;
		return $name;
	}

	/**
	 * Generate SQL Value or placeholder
	 * @param SQLValue $expr
	 * @return string
	 */
	function compileValue(SQLValue $expr)
	{
		if (!$this->isParametrized) {
			return ($expr->generate($this->generator));
		}
		$name = $this->createParamName();

		$this->params[] = new DBParam($name,
			SQLValue::getDbParamType($expr->value, $expr->type),
			SQLValue::getDbParamValue($expr->value, $expr->type, $this->generator));
		return $name;
	}

	function compileLike(string $name, string $value):string
	{
		if (!$this->isParametrized) {
			return $this->generator->generateLikeCondition($name, $value);
		}
		$pholder = $this->createParamName();

		$this->params[] = new DBParam($pholder,
			SQLValue::getDbParamType($value),
			$this->generator->generateSearchString($value));

		return "$name LIKE $pholder";
	}

	/**
	 * @param  IExpression $expr
	 * @param string|null $type
	 * @return string
	 * @throws Exception
	 */
	function compile(IExpression $expr, ?string $type = null)
	{
		if ( $expr instanceof SQLValue) {
			return $this->compileValue(instance_cast($expr, SQLValue::class));
		}

		if ($expr instanceof SQLName) {
			$genName = instance_cast($expr, ICanGenerateOne::class);
			return ($genName->generate($this->generator, 0));
		}

		if ($expr instanceof DBColumnDefinition) {
			$exprColumn = instance_cast($expr, DBColumnDefinition::class);
			$sqlName = new SQLName($exprColumn->getTableAlias(), $exprColumn->getName());
			return ($sqlName->generate($this->generator));
		}

		if( $expr instanceof ICanCompileExpression) {
			/** @var ICanCompileExpression $exprCompile */
			$exprCompile = instance_cast($expr, ICanCompileExpression::class);
			return $exprCompile->compile($this);
		}

		if (!($expr instanceof SQLExpression)) {
			throw new Exception("Is not expression subclass given. Got: " . get_class($expr));
		}
		return "";
	}

	/**
	 * @param ICanGenerateOne $name
	 * @return string
	 */
	function getName(ICanGenerateOne $name)
	{
		return $name->generate($this->generator, $this->generationMode);
	}


	/**
	 * compile Expression
	 *
	 * @param  IExpression $expr expression
	 * @param SQLGenerator $generator SQL generator.
	 * @return string  compiled SQL query
	 */
	static function s_compile(&$expr, $generator)
	{
		$compiler = new ECompilerSQL($generator);
		return ($compiler->compile($expr));
	}
}
