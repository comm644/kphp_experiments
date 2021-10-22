<?php

namespace SimpleReflection;

class ArrayValue extends MixedValue
{
	/** @var object[] */
	private array $value;

	/**
	 * ArrayValue constructor.
	 * @param array|object[] $value
	 */
	public function __construct($value)
	{
		$this->value = $value;
	}

	/**
	 * @return object[]
	 */
	public function getValue(): array
	{
		return $this->value;
	}
}