<?php
namespace Sigmalab\SimpleReflection;


use Exception;

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

	public function set_as_string(string  $name, string $value):void;
	public function set_as_int(string  $name, int $value):void;
	public function set_as_float(string  $name, float $value):void;
	public function set_as_bool(string  $name, bool $value):void;
	public function set_as_null(string  $name):void;

	/**
	 * @param string $name
	 * @param mixed $value
	 */
	public function set_as_mixed(string $name, $value):void;

	/**
	 * @param string $name
	 * @param \Sigmalab\SimpleReflection\IReflectedObject $value
	 */
	public function set_as_object(string $name, \Sigmalab\SimpleReflection\IReflectedObject $value):void;

	/**
	 * @param string $name
	 * @param \Sigmalab\SimpleReflection\IReflectedObject[] $value
	 * @throws Exception
	 */
	public function set_as_objects(string $name, array $value):void;

}