<?php

use SimpleReflection\ClassRegistry;

#ifndef KPHP

spl_autoload_register(function (string $class_name) {

	$filename = str_replace('\\', '/', $class_name) . '.php';
	require_once($filename);
});
#endif


require_once(__DIR__ . '/vkcom/kphp-polyfills/kphp_polyfills.php');


$object = new A();


//foreach( get_object_vars($object) as $key =>$value ) {
//	echo "$key  == $value\n";
//}

ClassRegistry::init();
A_reflection::registerClass();
B_reflection::registerClass();

echo "\n\ninstance_to_array:\n";
foreach (instance_to_array($object) as $key => $value) {
	if (is_array($value)) {
		echo "$key  == array\n";
	} else if (is_object($value)) {
		echo "$key  == object\n";
	} else {
		echo "$key  == $value\n";
	}
}

echo "\nimport from json with simple reflection:\n";
//$jsonArray = json_decode('{"name":"text", "value":10}', true );

echo "Parsing json:\n$json\n";

$json = <<<JSON
{"name":"text","value":10,
	"myarray":[1, 2, 3],
	"stringArray":["s1", "s2"],
	"floatArray":[1.5, 2.0],
	"boolArray":[true, false],
	"arrayB":[{"other":"in array"}],
	"valueB":{"other":"in object"}}
JSON;

$jsonArray = json_decode($json, true);
echo "in:\n".json_encode($jsonArray, JSON_UNESCAPED_UNICODE)."\n";
JsonParser::parse($jsonArray, $object);
echo "out:\n".json_encode(instance_to_array($object), JSON_UNESCAPED_UNICODE)."\n";

/** @var B $o2 */
$o2 = instance_cast(JsonParser::jsonDecodeObject('{"other":"in object"}', B::class), B::class);
echo "property: {$o2->other}\n";
;
$array2 = JsonParser::jsonDecodeObjectArray('[{"other":"in object"}]', B::class);
foreach ($array2 as $arrayValue) {
	$object2 = instance_cast($arrayValue, B::class);

	echo "array property: {$object2->other}\n";
}




echo "\n\ncloned:\n";
$b = clone $object;
$b->name = "other";
foreach (instance_to_array($b) as $key => $value) {
	if (is_array($value)) {
		echo "$key  == array\n";
	} else if (is_object($value)) {
		echo "$key  == object\n";
	} else {
		echo "$key  == $value\n";
	}
}

echo "class:" . get_class($b) . "\n";


$objectA = ClassRegistry::createClass('A');
echo get_class($objectA);


//KPHP not support this
//$className = "A";
//$other= new $className;

