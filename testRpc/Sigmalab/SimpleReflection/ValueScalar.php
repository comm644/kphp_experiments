<?php


namespace Sigmalab\SimpleReflection;

class ValueScalar extends ValueMixed
{
	/** @var  mixed */
	protected $value;

	/**
	 * ScalarValue constructor.
	 * @kphp-template $value
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

	/**
	 * @return int
	 */
	public function get_as_int()
	{
		return (int)$this->value;
	}

	/**
	 * @return string
	 */
	public function get_as_string()
	{
		return (string)$this->value;
	}

	/**
	 * @return float
	 */
	public function get_as_float()
	{
		return (float)$this->value;
	}

	/**
	 * @return bool
	 */
	public function get_as_bool()
	{
		return (bool)$this->value;
	}
	/**
	 * @return mixed
	 */
	public function get_as_mixed()
	{
		return $this->value;
	}

}