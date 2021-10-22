<?php


namespace SimpleReflection;

class ObjectValue extends MixedValue
{
	/** @var  object */
	protected $value;
	public TypeName $type;

	/**
	 * ObjectValue constructor.
	 * @param object $value
	 */
	public function __construct($value)
	{
		$this->value = $value;
	}

	public function getValue(): object
	{
		return $this->value;
	}

}