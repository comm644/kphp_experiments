<?php
namespace Sigmalab\SimpleReflection;


require_once __DIR__.'/TypeName.php';

interface ICanReflection
{
	/**
	 * @param string $name
	 * @return TypeName
	 */
	public function getPropertyType(string $name): TypeName;

	public function setPropertyValue(string $name, ValueMixed $value): void;

	public function getPropertyValue(string $name): ValueMixed;

	/**
	 * @param string $methodName
	 * @param \Sigmalab\SimpleReflection\ValueMixed[] $args
	 */
	public function callMethod(string $methodName, array $args) : void;
}