<?php


namespace Sigmalab\Database\Core;

interface IDataObject extends IObjectChanged
{
	/** returns primary key name (obsolete/internal use only)
	 * @return string primary key column name as \b string
	 */
	function primary_key():string;

	/**
	 * @return mixed
	 */
	function primary_key_value();

	/** Get columns
	 * @return DBColumnDefinition[]
	 */
	function getColumnDefinition(): array;

	/** Get column definition for extended object
	 *
	 * @param DBColumnDefinition[] $columns
	 * @return DBColumnDefinition[]
	 */
	function getColumnDefinitionExtended(array &$columns): array;


	/** Get table name
	 * @return string
	 */
	function table_name(): string;

	/** Gets table alias
	 * @return string
	 */
	function getTableAlias():string;


	/** set property value with state control
	 * @param string $name member name
	 * @param mixed $value new member value
	 * @return bool \a true  if new value is equals, or \a false  if member was changed
	 * */
	function setValue(string $name, $value);

}
