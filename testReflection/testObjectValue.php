<?php


$valueB = new \Sigmalab\SimpleReflection\ValueObject(new B);

$valueA = new \Sigmalab\SimpleReflection\ValueObject(new A);
//
//
///** @var B $b */
//$b = instance_cast($value->getValue(), B::class);
//echo $b->other;

/** @var \Sigmalab\SimpleReflection\ValueMixed $mixed */
function func(\Sigmalab\SimpleReflection\ValueMixed $value)
{
	if  ($value instanceof \Sigmalab\SimpleReflection\ValueObject){
		$object = $value->getValue();

		/** @var B $valB */
		$valB = instance_cast($object, B::class);
		if ($valB) {
			echo "class B:" .$valB->other."\n";
		}

		/** @var A $valA */
		$valA = instance_cast($object, A::class);
		if ($valA) {
			echo "class A:" .$valA->name."\n";
		}

	}
}
func($valueB);
func($valueA);
