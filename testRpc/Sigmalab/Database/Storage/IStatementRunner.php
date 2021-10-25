<?php

use Sigmalab\Database\Sql\SQLStatement;

/**
 * Interface IStatementRunner provides abstract access to Database interaction level.
 */
interface IStatementRunner
{
	function execute(SQLStatement $stm);
}