<?php


namespace SimpleReflection;

use SimpleReflection\MixedValue;

class ScalarValue extends MixedValue
{
	/** @var  mixed */
	protected $value;

	/**
	 * ScalarValue constructor.
	 * @param mixed $value
	 */
	public function __construct($value)
	{
		$this->value = $value;
	}

	/**
	 * @return mixed
	 */
	public function getValue()
	{
		return $this->value;
	}

}