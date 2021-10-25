<?php

namespace Sigmalab\Json;

use Sigmalab\SimpleReflection\ValueObjects;
use Sigmalab\SimpleReflection\ClassRegistry;
use Sigmalab\SimpleReflection\ICanReflection;
use Sigmalab\SimpleReflection\IReflectedObject;
use Sigmalab\SimpleReflection\ValueObject;
use Sigmalab\SimpleReflection\ValueScalars;
use Sigmalab\SimpleReflection\ValueScalar;
use Sigmalab\SimpleReflection\TypeName;

class JsonParser
{

	/**
	 * @param mixed[] $jsonArray
	 * @param IReflectedObject $object
	 * @param string $prefix
	 */
	public static function parse(array $jsonArray, IReflectedObject $object, $prefix = '')
	{
		/** @var ICanReflection $ref */
		$ref = ClassRegistry::createReflection(get_class($object), $object);

		foreach ($jsonArray as $key => $value) {
			//my own reflection
			$propName = (string)$key;
			$propType = $ref->getPropertyType($propName);

			if (is_scalar($value)) {
				$ref->set_as_mixed($propName, $value);
				continue;
			}

			if (is_array($value)) {
				if ($propType->type == TypeName::Array) {
					if (is_scalar($value[0])) {
						$ref->set_as_mixed($propName, $value);
					} else {
						$propArray = self::parseObjectArray($propType, $value);
						//$ref->setPropertyValue($propName, new ValueObjects($propArray));
						$ref->set_as_objects($propName, $propArray);
					}
				} else if ($propType->type == TypeName::Object) {
					$propInstance = self::parseObjectValue($propType, $value);
					$ref->set_as_object($propName, $propInstance);
				}
			}
		}
	}

	/**
	 * @param TypeName $propType
	 * @param mixed[] $json
	 * @return object
	 */
	public static function parseObjectValue(TypeName $propType, array $json): object
	{
		/** @var IReflectedObject $propInstance */
		$propInstance = ClassRegistry::createClass($propType->name);
		self::parse($json, $propInstance, '  ');
		return $propInstance;
	}

	/**
	 * @param TypeName $propType
	 * @param array $jsonArray
	 * @return object []
	 */
	public static function parseObjectArray(TypeName $propType, array $jsonArray): array
	{
		/** @var object [] $propArray */
		$propArray = [];
		/** @var array|mixed $jsonValue */
		foreach ($jsonArray as $jsonValue) {
			/** @var object $propInstance */
			$propInstance = self::parseObjectValue($propType, self::convertMixedToArray($jsonValue));
			$propArray[] = $propInstance;
		}
		return $propArray;
	}


	public static function jsonDecodeObject(string $json, string $className): object
	{
		$propType = new TypeName($className, TypeName::Object);
		$array = self::parseToArray($json);
		return JsonParser::parseObjectValue($propType, (array)$array);
	}

	public static function jsonDecodeObjectArray(string $json, string $className): array
	{
		$propType = new TypeName($className, TypeName::Array);
		/** @var array $array */
		$array = self::parseToArray($json);
		return JsonParser::parseObjectArray($propType, $array);
	}

	/**
	 * @param string $json
	 * @return mixed[]
	 */
	public static function parseToArray(string $json) :array
	{
		$mixed = json_decode($json, true);
		$result = [];
		foreach ($mixed as $key=>$value){
			$result[$key] = $value;
		}
		return $result;
	}

	/**
	 * @param mixed $mixed
	 * @return mixed[]
	 */
	public static function convertMixedToArray($mixed) :array
	{
		$result = [];
		foreach ($mixed as $key=>$value){
			$result[$key] = $value;
		}
		return $result;
	}
}

