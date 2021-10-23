<?php

use Sigmalab\SimpleReflection\ClassRegistry;
use Sigmalab\SimpleReflection\ValueScalar;

#ifndef KPHP
spl_autoload_register(function (string $class_name) {
	$filename = str_replace('\\', '/', $class_name) . '.php';
	require_once($filename);
});
#endif
require_once(__DIR__ . '/vkcom/kphp-polyfills/kphp_polyfills.php');



//We can't create array mixed different type of values.
$args= [
	new ValueScalar("s1"),
	new ValueScalar(10),
	new \Sigmalab\SimpleReflection\ValueScalars([1, 2, 3]),
	new \Sigmalab\SimpleReflection\ValueObjects((array)[new B]),
	new \Sigmalab\SimpleReflection\ValueObject(new B)
	];

ClassRegistry::init();
B_reflection::registerClass();

/** @var \Sigmalab\SimpleReflection\IReflectedObject $instanceB */
$instanceB = new B();
$ref = ClassRegistry::createReflection(B::class, $instanceB);
$ref->callMethod("methodA", $args);

$map = [
	"other"=>"s1"
];

foreach ($map as $key=>$value)
{
	$ref->callMethod("set_".$key, [new ValueScalar($value)]);
}

echo "\nargs:" . $argc ."\n";
foreach ($argv as $arg) {
	echo "arg: ".$arg ."\n";
}