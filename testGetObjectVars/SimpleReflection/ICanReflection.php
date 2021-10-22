<?php


namespace SimpleReflection;

interface ICanReflection
{
	public function getPropertyType(string $name): \SimpleReflection\TypeName;

	public function setPropertyValue(string $name, MixedValue $value): void;

	public function getPropertyValue(string $name): MixedValue;
}