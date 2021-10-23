<?php

use Sigmalab\Json\ICanJson;
use Sigmalab\SimpleReflection\IReflectedObject;

class A implements ICanJson, IReflectedObject

{
	/** @var string */
	public string  $name = "string value";
	/** @var int */
	public int $value = 0;
	/** @var int[] */
	public array $myarray = [];

	/** @var string[] */
	public array $stringArray = [];

	/** @var float[] */
	public array $floatArray = [];

	/** @var bool[] */
	public array $boolArray = [];

	/** @var B[] */
	public array $arrayB = [];

	/** @var B */
	public B  $valueB;

	/**
	 * A constructor.
	 */
	public function __construct()
	{
		$this->valueB = new B();
	}

}
