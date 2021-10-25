<?php

use Database\Document;
use Sigmalab\AdoDatabase\TransportClient\TransportHttp;
use Sigmalab\Database\Core\IDataObject;
use Sigmalab\Database\Expressions\ExprEQ;
use Sigmalab\DatabaseEngine\Gate\GateDataSource;

//require_once __DIR__.'/vendor/vkcom/kphp-polyfills/kphp_polyfills.php';
#ifndef KPHP


require_once __DIR__.'/autoload.php';
#endif


\Sigmalab\SimpleReflection\ClassRegistry::init();;
\Database\Document_reflection::registerClass();

if ( 0 ) {
#ifndef KPHP
	$transport = new \Sigmalab\AdoDatabase\TransportClient\TransportSocketUnixDgram("/tmp/server.sock", "/tmp/client.sock");
	$transport = new \Sigmalab\AdoDatabase\TransportClient\TransportStreamUnixDgram("/tmp/server.sock", "/tmp/client.sock");
	$transport = new \Sigmalab\AdoDatabase\TransportClient\TransportStreamUDP("127.0.0.1", 43026);
#endif
}
else {
	//$transport = new TransportHttp("http://localtest.me/kphp-test/testRpc/server.php");
	$transport = new TransportHttp("http://127.0.0.1:8800");
}


$gate = new GateDataSource(
	"sqlite:testing.db",
	new Sigmalab\AdoDatabase\Sqlite\SqliteGenerator(),
	$transport
);

function test(GateDataSource $gate)
{

	$proto = new Database\Document();
	$stm = new Sigmalab\Database\Sql\SQLStatementSelect($proto);
	//$stm->setLimit(10);
	$stm->addExpression(ExprEQ::eqInt($proto->tag_documentType(), 0));
	$container = $stm->createResultContainer(true);

//	$server = new ServerAppSqlite();
//	$server->executeSelect($stm, $container);


	$gate->executeSelect($stm,$container );

	if ( 0 ) {
		dump($container->getResult());


		echo "\n";
		foreach ($container->getResult() as $row) {
			echo "[";
			/** @var mixed $item */
			foreach (instance_to_array($row) as $key => $item) {
				if (is_array($item)) {
					echo "\t\t$key => [some array]\n";
				} else {
					echo "\t\t$key => $item\n";
				}
			}
			echo "]\n";
		}
	}
}

/**
 * @param IDataObject[] $docs
 * @kphp-template Document
 */
function dump(array $docs)
{
	foreach ($docs as $key => $doc) {
		if ($doc instanceof Document) {
			echo "\n\nclass: " . get_class($doc) . "  key:" . $key . "\n";
			echo "Name:" . $doc->get_documentTitle() . "\n";
		}
	}
}

test($gate);

if ( 1 ) {

	$ncount = 100;
	$tm = microtime(true);
	for ($i = 0; $i < $ncount; ++$i) {
		test($gate);
	}
	$end = microtime(true);
	echo "\ntime: " . ($end - $tm) . "\n";
}

$transport->dispose();
