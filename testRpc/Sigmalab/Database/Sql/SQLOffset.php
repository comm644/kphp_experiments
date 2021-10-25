<?php
/******************************************************************************
 * Copyright (c) 2007 by Alexei V. Vasilyev.  All Rights Reserved.
 * -----------------------------------------------------------------------------
 * Module     : keyword OFFSET
 * File       : SQLOffset.php
 * Author     : Alexei V. Vasilyev
 * -----------------------------------------------------------------------------
 * Description:
 ******************************************************************************/

namespace Sigmalab\Database\Sql;

/**
 * SQL:  'OFFSET'  construction
 *
 */
class SQLOffset extends SQLParam
{
	function generate(SQLGenerator $generator)
	{
		if (!$this->value) return "";

		$dic = $generator->getDictionary();
		return $this->_generate($dic->sqlOffset);
	}
}

