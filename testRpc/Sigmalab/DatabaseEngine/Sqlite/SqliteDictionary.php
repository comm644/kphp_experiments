<?php


namespace Sigmalab\AdoDatabase\Sqlite;
use Sigmalab\Database\Sql\SQLDic;

class  SqliteDictionary extends SQLDic
{


	/**
	 * SqliteDictionary constructor.
	 */
	public function __construct()
	{
		$this->sqlOpenName = "";
		$this->sqlCloseName = "";
	}

}
