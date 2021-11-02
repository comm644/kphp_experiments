<?php

$libA = FFI::load(__DIR__.'/str_return.h' );

$lib = FFI::scope("STRING");

$in = "instr";
//$out = "";
$out = FFI::new("const char*");

$lib->str_return($in, FFI::addr($out));
//$lib->str_return($in, $out));

var_dump($out);


