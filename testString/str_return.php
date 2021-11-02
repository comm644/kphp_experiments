<?php

#ifndef KPHP
define('kphp', 0);
if (false)
#endif
  define('kphp', 1);
  
  

#ifndef KPHP
$lib =  FFI::load(__DIR__.'/str_return.h' );
if ( false )
#endif
{
	FFI::load(__DIR__.'/str_return.h' );
	$lib = FFI::scope("STRING");
}


$in = "instr";
//$out = "";
$out = FFI::new("const char*");

$lib->str_return($in, FFI::addr($out));
//$lib->str_return($in, $out));


//var_dump(FFI::string($out));


