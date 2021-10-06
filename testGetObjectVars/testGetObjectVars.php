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


foreach( instance_to_array($object) as $key =>$value ) {
	echo "$key  == $value\n";
}

//my own reflection
A_reflection::setPropertyValue($object, "name", "other string");

echo "prop value: " . A_reflection::getPropertyValue($object, "name") ."\n";

foreach( instance_to_array($object) as $key =>$value ) {
	echo "$key  == $value\n";
}
