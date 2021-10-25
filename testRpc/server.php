<?php


use Sigmalab\DatabaseEngine\GateServer\Sqlite\GateServerSqlite;

require_once(__DIR__ . '/autoload.php');


function processInput(callable $app)
{
	$request = file_get_contents("php://input");
	echo $app($request);
}

$app = new GateServerSqlite();
processInput(function ($request) use($app){
	return $app->handleRequest($request);
});
