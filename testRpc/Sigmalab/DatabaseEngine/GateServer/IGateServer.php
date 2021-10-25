<?php

namespace Sigmalab\DatabaseEngine\GateServer;

use Sigmalab\DatabaseEngine\Gate\SqlQuery;
use Sigmalab\DatabaseEngine\Gate\SqlResponse;

interface IGateServer
{
	public function executeQuery(SqlQuery $query): SqlResponse;
}