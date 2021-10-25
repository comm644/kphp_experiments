<?php

namespace Sigmalab\SimpleReflection;
use Sigmalab\SimpleReflection\ValueMixed;

class ValueScalars extends ValueMixed
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

	/**
	 * @return int[]
	 */
	public function get_as_int() : array
	{
		/** @var int[] $result */
		$result = [];
		if (!count( $this->value) ) return $result;
		$arrayKey  = array_first_key($this->value);
		if ( $arrayKey === 0) {
			foreach( $this->value as $item ) {
				$result[] = (int)$item;
			}
			return $result;
		}


		foreach ($this->value as $key=>$item){
			$result[$key] = (int)$item;
		}
		return $result;
	}

	/**
	 * @return string[]
	 */
	public function get_as_string() : array
	{
		/** @var string[] $result */
		$result = [];
		if (!count( $this->value) ) return $result;
		$arrayKey  = array_first_key($this->value);
		if ( $arrayKey === 0) {
			foreach( $this->value as $item ) {
				$result[] = (string)$item;
			}
			return $result;
		}

		foreach ($this->value as $key=>$item){
			$result[$key] = (string)$item;
		}
		return $result;
	}
	/**
	 * @return float[]
	 */
	public function get_as_float() : array
	{
		/** @var float[] $result */
		$result = [];
		if (!count( $this->value) ) return $result;
		$arrayKey  = array_first_key($this->value);
		if ( $arrayKey === 0) {
			foreach( $this->value as $item ) {
				$result[] = (float)$item;
			}
			return $result;
		}

		foreach ($this->value as $key=>$item){
			$result[$key] = (float)$item;
		}
		return $result;
	}
	/**
	 * @return bool[]
	 */
	public function get_as_bool() : array
	{
		/** @var bool[] $result */
		$result = [];
		if (!count( $this->value) ) return $result;
		$arrayKey  = array_first_key($this->value);
		if ( $arrayKey === 0) {
			foreach( $this->value as $item ) {
				$result[] = (bool)$item;
			}
			return $result;
		}

		foreach ($this->value as $key=>$item){
			$result[$key] = (bool)$item;
		}
		return $result;
	}
}