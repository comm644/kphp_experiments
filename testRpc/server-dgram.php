<?php


use Sigmalab\DatabaseEngine\GateServer\Sqlite\GateServerSqlite;

require_once(__DIR__ . '/autoload.php');


$app = new GateServerSqlite();

try {
	$server = new \Sigmalab\AdoDatabase\Transport\Server\ServerUnixDgram();
	$server->main("/tmp/server.sock", function($req) use ($app ){
		return $app->handleRequest($req);
	});
}
catch (Exception $e)
{
	print_r($e);
}

