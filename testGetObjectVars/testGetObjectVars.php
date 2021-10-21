<?php

#ifndef KPHP
spl_autoload_register(function (string $class_name) {
	$filename   = $class_name . '.php';
    require_once( $filename );
});
#endif


require_once(__DIR__ .'/vkcom/kphp-polyfills/kphp_polyfills.php' );


$object = new A();


//foreach( get_object_vars($object) as $key =>$value ) {
//	echo "$key  == $value\n";
//}


echo "\n\ninstance_to_array:\n";
foreach( instance_to_array($object) as $key =>$value ) {
	echo "$key  == $value\n";
}

echo "\n\nimport from json with simple reflection:\n";
$jsonArray = json_decode('{"name":"text", "value":10}', true );
foreach($jsonArray as $key  => $value ) {
	//my own reflection
	$object->setPropertyValue((string)$key, $value );
}


echo "\n\nget value via reflection:\n";
echo "prop value: " . $object->getPropertyValue( "name") ."\n";

echo "instance_to_array with updated object:\n";
foreach( instance_to_array($object) as $key =>$value ) {
	echo "$key  == $value\n";
}
