<?php

define( "DBH_ADD", 0 );
define( "DBH_REMOVE", 1 );
define( "DBH_ADDLINK", 2 );
define( "DBH_REMOVELINK", 3 );
define( "DBH_UPDATE", 4 );

class DBHistory
{
	var $op;
	var $container;
	var $index;
	var $deletedObject = null;

	function __construct( $op, $container, $index, $deletedObject=null )
	{
		$this->op = $op;
		$this->container = $container;
		$this->index = $index;
		$this->deletedObject = $deletedObject;
	}
}

