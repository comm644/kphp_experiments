<?php


namespace Sigmalab\SimpleReflection;

class ValueObject extends ValueMixed
{
	/**
	 * @var object|IReflectedObject
	 */
	protected object $value;
//	public TypeName $type;

	/**
	 * ObjectValue constructor.
	 * @kphp-template $value
	 * @param object|IReflectedObject $value
	 */
	public function __construct(object $value)
	{
		$this->value = $value;
	}

	/**
	 * @return object|IReflectedObject
	 */
	public function getValue(): object
	{
		return $this->value;
	}

	/**
	 * @return object|IReflectedObject
	 */
	public function get_as_object() : object
	{
		return $this->value;
	}
}