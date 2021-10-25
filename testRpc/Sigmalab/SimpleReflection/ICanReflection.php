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
	public function invoke_as_void(string $methodName, array $args) : void;

	/**
	 * @param string $methodName
	 * @param array $args
	 * @return mixed
	 */
	public function invoke_as_mixed(string $methodName, array $args) ;

	/**
	 * @param string $methodName
	 * @param array $args
	 * @return ?IReflectedObject
	 */
	public function invoke_as_object(string $methodName, array $args) :?IReflectedObject;

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
	 * @return string
	 */
	public function get_as_string(string  $name):string;

	/**
	 * @param string $name
	 * @return int
	 */
	public function get_as_int(string  $name):int;

	/**
	 * @param string $name
	 * @return float
	 */
	public function get_as_float(string  $name):float;

	/**
	 * @param string $name
	 * @return bool
	 */
	public function get_as_bool(string  $name):bool ;

	/**
	 * @param string $name
	 * @param $value
	 * @return mixed
	 */
	public function get_as_mixed(string $name);

	/**
	 * @param string $name
	 * @param IReflectedObject $value
	 */
	public function set_as_object(string $name, IReflectedObject $value):void;

	/**
	 * @param string $name
	 * @return ?IReflectedObject
	 */
	public function get_as_object(string $name): ?IReflectedObject;

	/**
	 * @param string $name
	 * @param IReflectedObject[] $value
	 * @throws Exception
	 */
	public function set_as_objects(string $name, array $value):void;

	/**
	 * @param string $name
	 * @return \Sigmalab\SimpleReflection\IReflectedObject[]
	 * @throws Exception
	 */
	public function get_as_objects(string $name):array;


//	/**
//	 * @param string $name
//	 * @param mixed[] $value
//	 */
//	public function set_as_array(string $name, array $value):void;
}