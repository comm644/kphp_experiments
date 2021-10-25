<?php

namespace Sigmalab\Database\Expressions;

use Sigmalab\Database\Core\DBColumnDefinition;
use Sigmalab\Database\Sql\ICanGenerateOne;
use Sigmalab\Database\Sql\SQLGenerator;

class ExprColumnsEQ implements IExpression, ICanGenerateOne
{
	/**
	 * @var string
	 */
	public string $mode = ""; //join mode

	public DBColumnDefinition $arg;
	public DBColumnDefinition $name;

	/**
	 * ExprEQ constructor.
	 * @param DBColumnDefinition $name
	 * @param DBColumnDefinition $arg
	 * @kphp-template $arg
	 */
	function __construct(DBColumnDefinition $name, DBColumnDefinition $arg)
	{
		$this->name = $name;
		$this->arg = $arg;
		$this->mode = "=";
	}

	/**
	 * @inheritDoc
	 */
	function generate(SQLGenerator $generator, int $cause = 0): string
	{

		return ECompilerSQL::s_sqlGroup(
			$this->name->generate($generator, $cause)
			. ' ' . $this->mode . ' '
			. $this->arg->generate($generator, $cause));
	}
}