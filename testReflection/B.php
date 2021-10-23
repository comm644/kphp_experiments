<?php


use Sigmalab\Json\ICanJson;
use Sigmalab\SimpleReflection\IReflectedObject;

class B implements ICanJson, IReflectedObject
{
	/** @var string  */
	public string $other ='test';

	/**
	 * @param string $arg
	 * @param int $value
	 * @param int[] $values
	 * @param B[] $objects
	 * @param B $object
	 */
	public function methodA(string $arg, int $value, array $values, array $objects, B $object)
	{
#ifndef KPHP
		var_dump(func_get_args());
#endif
		echo $arg;
	}

	/**
	 * @param string $value
	 */
	public function set_other(string $value)
	{
		echo "set value\n";
		$this->other =$value;
	}
}