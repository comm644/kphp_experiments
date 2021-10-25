<?php

namespace Sigmalab\Database\Sql;
use Sigmalab\Database\Core\DBColumnDefinition;
use Sigmalab\Database\Core\DBObject;

/** DOc not use this class. required only for creating type info */
class DBObjectMock extends DBObject
{
	/**
	 * @return DBColumnDefinition[]
	 */
	function getColumnDefinition(): array
	{
		return array();
	}

	function table_name(): string
	{
		return "";
	}

	/** returns primary key name (obsolete/internal use only)
	 * @return string primary key column name as \b string
	 */
	function primary_key():string
	{
		return 'key';
	}
}