<?php

namespace Sigmalab\Database\Core;
use Sigmalab\Database\Sql\SQLStatement;

/**
 *
 * \brief object oriented data source access interface
 *
 * This inteface profviced object oriented access to datasources and
 * performs executing SQLStatements only without direct queries
 */
abstract class IDataSource
{

	/** method performs connecting to data base
	 * @param $dsn \b string describes Data Source Name  as next string:
	 * engine_name://username:password@server[:port]/database
	 * @return integer error code as \b enum specified for concrete data source
	 */
	abstract function connect($dsn);

	/** execute SQLstatement
	 * @param $statement SQLStatement object
	 * @return integer success code
	 */
	abstract function queryStatement($statement, $resultContainer = NULL);

	function beginTransaction()
	{
	}

	function commitTransaction()
	{
	}
}

define("CLASS_IDataSource", 'IDataSource');
