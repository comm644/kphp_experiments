<?php

namespace Sigmalab\Database\Sql;

interface ICanGenerateOne
{
	/** Generate SQL code for defined column in SQL
	 *
	 * @param SQLGenerator $generator
	 * @param int $cause cause of generation, see:
	 * @return string
	 * @see \Sigmalab\Database\Core\DBGenCause
	 */
	function generate(SQLGenerator $generator, int $cause=0) : string;
}