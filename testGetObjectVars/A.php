<?php

class A implements ICanJson
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
