<?php

use Sigmalab\Json\JsonParser;
use Sigmalab\SimpleReflection\ClassRegistry;
use Sigmalab\SimpleReflection\ValueObject;
use Sigmalab\SimpleReflection\ValueObjects;
use Sigmalab\SimpleReflection\ValueScalar;

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

$json = <<<JSON
{"name":"text","value":10,
	"myarray":[1, 2, 3],
	"stringArray":["s1", "s2"],
	"floatArray":[1.5, 2.0],
	"boolArray":[true, false],
	"arrayB":[{"other":"in array"}],
	"valueB":{"other":"in object"}}
JSON;

echo "Parsing json:\n$json\n";

/** @var mixed[] $jsonArray */
$jsonArray = JsonParser::parseToArray($json);
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

function dump(object $obj): void
{
	foreach (instance_to_array($obj) as $key => $value) {
		if (is_array($value)) {
			echo "$key  == array\n";
			foreach ($value as $arrayKey => $item) {
				if (is_scalar($item)) {
					echo "    $arrayKey  == $item\n";
				}
				else {
					echo "    $arrayKey  == non scalar\n";
				}
			}

		} else if (is_object($value)) {
			echo "$key  == object\n";
		} else {
			echo "$key  == $value\n";
		}
	}
}

dump($b);

echo "class:" . get_class($b) . "\n";


$objectA = ClassRegistry::createClass('A');
echo get_class($objectA);



$ref = ClassRegistry::createReflection(A::class, $objectA);

//very fast - without boxing
$ref->set_as_string("name", "some string");
$ref->set_as_int("value", 20);

//fast - with boxing
$ref->set_as_mixed("name", "some string");
$ref->set_as_mixed("value", 10);
$ref->set_as_mixed("boolValue", true);
$ref->set_as_mixed("myarray", [1, 2, 3]);

//fast - without boxing (only dynamic_cast<>)
$ref->set_as_object("valueB", new B());
$ref->set_as_object("valueA", new A());

//not so fast, array copying to target property
$mixed = [new B, new B];
$ref->set_as_objects("arrayB", $mixed);

//slow - double unboxing (mixed + ValueScalar), allocating memory for ValueScalar, check instanceof
$ref->setPropertyValue("name", new ValueScalar("slow"));

//not so fast - inline unboxing (ValueObject), allocating memory for ValueScalar, dynamic_cast<>, check instanceof
$ref->setPropertyValue("valueB", new ValueObject(new B));

//very slow - array copying, allocating memory for ValueObjects, dynamic_cast<>, check instanceof
$ref->setPropertyValue("arrayB", new ValueObjects([new B, new B]));

echo "\n\ndump\n";
dump($objectA);

//KPHP not support this
//$className = "A";
//$other= new $className;

