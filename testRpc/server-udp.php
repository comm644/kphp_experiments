<?php


use Sigmalab\DatabaseEngine\GateServer\Sqlite\GateServerSqlite;

require_once(__DIR__ . '/autoload.php');


$app = new GateServerSqlite();

try {
	$server = new \Sigmalab\AdoDatabase\Transport\Server\ServerUdp();
	$server->main("127.0.0.1", 43002, function($req) use ($app ){
		return $app->handleRequest($req);
	});
}
catch (Exception $e)
{
	print_r($e);
}

