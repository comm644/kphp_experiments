<?php

namespace Sigmalab\Database\Sql;

use Sigmalab\Database\Core\DBColumnDefinition;
use Sigmalab\Database\Core\DBForeignKey;
use Sigmalab\Database\Core\IDataObject;
use Sigmalab\Database\Expressions\ExprAND;
use Sigmalab\Database\Expressions\ExprColumnsEQ;
use Sigmalab\Database\Expressions\IExpression;

/**
 * This class incapsulates easy joining tables engine.
 *
 * You no need think about "how to join tables". Just amek join tables via
 * column pair or foreign key.  All DBObject objects already contains
 * all necessary metadata for joining.
 */
class SQLJoin
{

	/**
	 * tag from owner object
	 * @var DBColumnDefinition
	 */
	var $ownerTag;

	/**
	 * tag from fereign object
	 * @var DBColumnDefinition
	 */
	var $foreignTag;

	/**
	 * user expression for join
	 * @var  IExpression
	 */
	var $expr = null;


	private function __construct()
	{
	}

	/**
	 * Construct join for specified forign key.
	 *
	 * @param DBForeignKey $key
	 * @param IDataObject $ownerObject owner object for detecting base table.
	 * @return SQLJoin
	 */
	static function createByKey(DBForeignKey $key, IDataObject $ownerObject = null)
	{
		$join = new SQLJoin();
		if (get_class($key) != DBForeignKey::class) {
			throw new \Exception(sprintf("'Key' parameter must be DBForeignKey type, but got '%s'", get_class($key)));
		}

		if ($ownerObject && $ownerObject->table_name() != $key->ownerTag->getTableName()) {
			$join->ownerTag = $key->foreignTag;
			$join->foreignTag = $key->ownerTag;
		} else {
			$join->ownerTag = $key->ownerTag;
			$join->foreignTag = $key->foreignTag;
		}

		return ($join);
	}

	/**
	 *  Construct Jon by column pair.
	 *
	 * @param DBColumnDefinition $ownerTag owner object column
	 * @param DBColumnDefinition $foreignTag join object column
	 * @return SQLJoin
	 */
	static function createByPair(DBColumnDefinition $ownerTag, DBColumnDefinition $foreignTag, $expr = null)
	{
		$join = new SQLJoin();
		$join->ownerTag = $ownerTag;
		$join->foreignTag = $foreignTag;
		if ($expr) {
			$join->addExpression($expr);
		}
		return ($join);

	}

	/**
	 * Create by key strictly. without smart logic.
	 * @param DBForeignKey $key
	 * @return SQLJoin
	 */
	public static function createByMasterKey(DBForeignKey $key)
	{
		$join = new SQLJoin();
		$join->ownerTag = $key->ownerTag();
		$join->foreignTag = $key->foreignTag();
		return ($join);
	}

	/**
	 * Create by key strictly. without smart logic.
	 * @param DBForeignKey $key
	 * @return SQLJoin
	 */
	public static function createBySlaveKey(DBForeignKey $key)
	{
		$join = new SQLJoin();
		$join->ownerTag = $key->foreignTag();
		$join->foreignTag = $key->ownerTag();
		return ($join);
	}

	/**
	 * Add expression for Join.
	 *
	 * @param  IExpression $expr
	 */
	function addExpression( IExpression $expr)
	{
		$this->expr = $expr;
		return $this;
	}

	function generate(SQLGenerator $generator)
	{
		$sql = $generator->getDictionary();

		$parts = array();

		$tableName = new SQLAlias(
			$this->foreignTag->getTableName(),
			null,
			$this->foreignTag->table->getTableAlias());

		$expr = new ExprColumnsEQ($this->foreignTag, $this->ownerTag);

		if (!is_null($this->expr)) {
			$expr = new ExprAND([$expr, $this->expr]);
		}

		$parts[] = $sql->sqlLeftJoin;
		$parts[] = $tableName->generate($generator);
		$parts[] = $sql->sqlOn;
		$parts[] = SQL::compileExpr($expr, $generator);

		return (implode(" ", $parts));
	}
}

