<?php
/******************************************************************************
 * Copyright (c) 2007-2019 by Alexei V. Vasilyev.  All Rights Reserved.
 * -----------------------------------------------------------------------------
 * Module     : keyword LIMIT
 * File       : SQLLimit.php
 * Author     : Alexei V. Vasilyev
 * -----------------------------------------------------------------------------
 * Description:
 ******************************************************************************/

namespace Sigmalab\Database\Sql;

/**
 * SQL: LIMIT keyword
 *
 */
class SQLLimit extends SQLParam
{
	function generate(SQLGenerator $generator)
	{
		if (!$this->value) return "";

		$dic = $generator->getDictionary();
		return $this->_generate($dic->sqlLimit);
	}
}

