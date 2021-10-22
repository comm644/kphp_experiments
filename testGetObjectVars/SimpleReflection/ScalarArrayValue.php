<?php

namespace SimpleReflection;
use SimpleReflection\MixedValue;

class ScalarArrayValue extends MixedValue
{
	/**
	 * @var mixed[]
	 */
	private array $value;

	/**
	 * ArrayValue constructor.
	 * @kphp-template $value
	 * @param mixed[] $value
	 */
	public function __construct($value)
	{
		$this->value = $value;
	}

	/**
	 * @return mixed[]
	 */
	public function getValue(): array
	{
		return $this->value;
	}
}