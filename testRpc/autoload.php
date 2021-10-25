<?php

require_once __DIR__.'/vendor/autoload.php';
#ifndef KPHP

spl_autoload_register(function (string $class_name) {

	$filename = str_replace('\\', '/', $class_name) . '.php';
	require_once($filename);
});
#endif