<?php


namespace Sigmalab\SimpleReflection;

class ValueObject extends ValueMixed
{
	/**
	 * @var IReflectedObject
	 */
	protected IReflectedObject $value;
//	public TypeName $type;

	/**
	 * ObjectValue constructor.
	 * @kphp-template $value
	 * @param IReflectedObject $value
	 */
	public function __construct(IReflectedObject $value)
	{
		$this->value = $value;
	}

	/**
	 * @return IReflectedObject
	 */
	public function getValue(): IReflectedObject
	{
		return $this->value;
	}

	/**
	 * @return IReflectedObject
	 */
	public function get_as_object() : IReflectedObject
	{
		return $this->value;
	}
}