<?php
/******************************************************************************
 * Copyright (c) 2007 by Alexei V. Vasilyev.  All Rights Reserved.
 * -----------------------------------------------------------------------------
 * Module     : DB result container
 * File       : DBResultcontainer.php
 * Author     : Alexei V. Vasilyev
 * -----------------------------------------------------------------------------
 * Description:
 ******************************************************************************/


namespace Sigmalab\Database\Core;
/** DB result container abstract class. implement saving result STRATEGY
 */
abstract class DBResultContainer
{
	/**
	 * @var IDataObject[]
	 */

	protected array $data = array();

	/** methods will be called on begin reading stream
	 */
	function begin()
	{
		$this->data = array();
	}

	/** method should to add object to result container
	 * @param IDataObject $object
	 */
	function add(IDataObject $object)
	{
		$this->data[] = $object;
	}

	/**
	 * method should convert read associative array to object hich will be stored via method  add()
	 * @param mixed[] $sqlLine
	 * @return IDataObject
	 */
	abstract function fromSQL(array $sqlLine) : IDataObject;

	/** method will be called on end of reading sql result
	 */
	function end()
	{
	}


	/** method returns result
	 * @return IDataObject[]
	 */
	function getResult()
	{
		return $this->data;
	}
}

