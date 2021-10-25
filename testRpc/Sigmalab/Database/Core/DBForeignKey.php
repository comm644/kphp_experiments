<?php

namespace Sigmalab\Database\Core;

class DBForeignKey
{
	/**
	 * tag from owner object
	 * @var DBColumnDefinition  owner primary key
	 */
	var $ownerTag;

	/**
	 * tag from foreign object
	 *
	 * @var DBColumnDefinition  foreign key
	 */
	var $foreignTag;

	function __construct($ownerTag, $foreignTag)
	{

		$this->ownerTag = $ownerTag;
		$this->foreignTag = $foreignTag;
	}

	/**
	 * @return \Sigmalab\Database\Core\DBColumnDefinition
	 */
	public function foreignTag()
	{
		return $this->foreignTag;
	}

	/**
	 * @return \Sigmalab\Database\Core\DBColumnDefinition
	 */
	public function ownerTag()
	{
		return $this->ownerTag;
	}


}

