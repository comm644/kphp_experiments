<?php

#ifndef KPHP

spl_autoload_register(function (string $class_name) {
	$filename = str_replace('\\', '/', $class_name) . '.php';
	require_once($filename);
});

$app = new \Sigmalab\SimpleReflection\ReflectionGenerator();
echo $app->generate($argv[1]);
#endif

