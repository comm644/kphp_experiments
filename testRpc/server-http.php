<?php


use Sigmalab\DatabaseEngine\GateServer\Sqlite\GateServerSqlite;

require_once(__DIR__ . '/autoload.php');

$app = new GateServerSqlite();

$server = new \Sigmalab\AdoDatabase\Transport\Server\ServerHttp();
$server->main('0.0.0.0:8800',function($req) use ($app ){
	return $app->handleRequest($req);
});
