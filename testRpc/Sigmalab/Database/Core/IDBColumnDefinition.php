<?php

namespace Sigmalab\Database\Core;

use Sigmalab\Database\Sql\ICanGenerateOne;

/**
 * This class defines meta information about database column.
 *
 * Usually in generated code this class used as return valie in tag_*() methods.
 */
interface IDBColumnDefinition
	extends ICanGenerateOne
{
	/**
	 * Gets column name. Methods retuns raw column name.
	 *
	 * @return string
	 */
	public function getName();

	/**
	 * Gets column alias if defined.
	 * If column alias is not defined then method returns column name.
	 *
	 * @return string
	 */
	function getAlias();

	/**
	 * Gets alias or name for binding destination column name.
	 * Main idea is : value in result set can be binded to another member.
	 * member name in this case need set by Alias, another words, column name
	 * always have using as member name.
	 *
	 * @return string
	 */
	function getAliasOrName();

	/**
	 * Gets table alias.
	 * Method returns table alias if alias defined. If table alias is not defined
	 * then method returns table name.
	 *
	 * If table not defined for column then method returns null
	 *
	 * @return string|null ?string  table alias
	 */
	function getTableAlias():?string;

	/**
	 * Gets raw table name.
	 *
	 * @return string|null ?string
	 */
	function getTableName():?string ;

	public function equals(DBColumnDefinition $tag);

	/** @return bool */
	public function isNullable();

	/** @return string */
	public function getType();
}