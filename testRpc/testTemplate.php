<?php

class T{}
interface I{  }
class A implements I { 	function methodA(){ echo "A";	} }
class B implements I { 	function methodB(){ echo "B"; } }

class Holder
{
	public I $object;

	/**
	 * Holder constructor.
	 * @param I $object
	 * @kphp-template I $object
	 */
	public function __construct( $object)
	{
		$this->object = $object;
	}

	/**
	 * @param object $object
	 * @kphp-template $object
	 * @return Holder
	 */
	public static function create(object $object)
	{
		return new Holder($object);
	}
	/**
	 * @param $proto
	 * @return object
	 * @kphp-template T $proto
	 * @kphp-return T
	 */
	public function get(object $proto)
	{
		return instance_cast($this->object, T::class);
	}
}

$holderA = Holder::create(new A());
$holderB = Holder::create(new B());

/** @var A $varA */
$varA = $holderA->get(new A);
$varA->methodA();


/** @var B $varB */
$varB = $holderB->get(new B);
$varB->methodB();



////
///**
// * @param Holder $holder
// * @param object $class
// * @param $docs
// * @return array
// * @kphp-template T $class
// * @kphp-return   T[]
// */
//function fillDirect(Holder $holder, $class): array
//{
//	$docs = [new T];
//	for ($i = 0; $i < 10; ++$i) {
//		$docs[] = clone $holder->object;
//	}
//	return $docs;
//}
//
//
//
//
///** @var A[] $arrayA */
//$arrayA = fillDirect(new Holder(new A), new A);
//
///** @var B[] $arrayB */
//$arrayB = fillDirect(new Holder(new B), new B);
//
//


/**
 * @param Holder $holder
 * @param object $class
 * @param $docs
 * @return array
 * @kphp-template T $class
 * @kphp-return   T[]
 */
function fillWithCast(Holder $holder, $class): array
{
	$docs = [$class];
	for ($i = 0; $i < 10; ++$i) {
		$docs[] = instance_cast(clone $holder->object, T::class);
	}
	return $docs;
}


/** @var A[] $arrayA */
$arrayA = [];
$arrayA = fillWithCast(new Holder(new A), new A);
$arrayA[0]->methodA();

/** @var B[] $arrayB */
$arrayB = [];
$arrayB = fillWithCast(new Holder(new B), new B);
$arrayB[0]->methodB();


