<?php

use SimpleReflection\ClassRegistry;

ClassRegistry::registerClass("ClassRegistry", function(){ return new ClassRegistry();});

//Does not work:

$object = ClassRegistry::createClass('ClassRegistry');


//work:
/**
 * @param (callable():object) $handler
 * @return object
 */
function callHandler($handler)
{
	return $handler();
}
$other = callHandler(function(){ return new ClassRegistry();});

//Does not work

/** @var (callable():object)[] $handlers */
$handlers = [];
$handlers["A"] = function(){ return new ClassRegistry();};
$other2 = $handlers["A"]();


