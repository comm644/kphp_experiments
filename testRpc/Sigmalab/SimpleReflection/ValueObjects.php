<?php

namespace Sigmalab\SimpleReflection;

class ValueObjects extends ValueMixed
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

	/**
	 * @return object[]
	 */
	public function get_as_array(): array
	{
		return $this->value;
	}
}