<?php

use Sigmalab\Json\ICanJson;
use Sigmalab\SimpleReflection\IReflectedObject;

class A implements ICanJson, IReflectedObject

{
	/** @var string */
	public string  $name = "string value";
	/** @var int */
	public int $value = 0;

	/** @var int|null  */
	public ?int $nullableInt = null;

	/** @var float  */
	public float $floatValue = 0;

	/** @var bool  */
	public bool $boolValue = false;

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

	/** @var A */
	public ?A  $valueA = null;

	/**
	 * A constructor.
	 */
	public function __construct()
	{
		$this->valueB = new B();
	}

}
