<?php

use SimpleReflection\ArrayValue;
use SimpleReflection\ClassRegistry;
use SimpleReflection\ICanReflection;
use SimpleReflection\ObjectValue;
use SimpleReflection\ScalarArrayValue;
use SimpleReflection\ScalarValue;
use SimpleReflection\TypeName;

class JsonParser
{

	public static function parse($jsonArray, object $object, $prefix = '')
	{
		/** @var ICanReflection $ref */
		$ref = ClassRegistry::createReflection(get_class($object) , $object);

		foreach ($jsonArray as $key => $value) {
			//my own reflection
			$propName = (string)$key;
			$propType = $ref->getPropertyType($propName);

			if (is_scalar($value)) {
				$ref->setPropertyValue($propName, new ScalarValue($value));
				continue;
			}

			if (is_array($value)) {
				if ($propType->type == TypeName::Array) {
					if (is_scalar($value[0])) {
						$vector = [];
						foreach ($value as $arrayItem) {
							$vector [] = $arrayItem;
						}
						$ref->setPropertyValue($propName, new ScalarArrayValue($vector));
					} else {
						$propArray = self::parseObjectArray($propType, $value);
						$ref->setPropertyValue($propName, new ArrayValue($propArray));
					}
				} else if ($propType->type == TypeName::Object) {
					$propInstance = self::parseObjectValue($propType, $value);
					$ref->setPropertyValue($propName, new ObjectValue($propInstance));
				}
			}
		}
	}

	/**
	 * @param TypeName $propType
	 * @param $json
	 * @return object
	 */
	public static function parseObjectValue(TypeName $propType, $json): object
	{
		/** @var object  $propInstance */
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
			/** @var object  $propInstance */
			$propInstance = self::parseObjectValue($propType, $jsonValue);
			$propArray[] = $propInstance;
		}
		return $propArray;
	}


	public static function jsonDecodeObject(string $json, string $className) : object
	{
		$propType = new TypeName($className, TypeName::Object);
		$array = json_decode($json, true);
		return JsonParser::parseObjectValue($propType, $array);
	}
	public static function jsonDecodeObjectArray(string $json, string $className) : array
	{
		$propType = new TypeName($className, TypeName::Array);
		/** @var array $array */
		$array = (array)json_decode($json, true);
		return JsonParser::parseObjectArray($propType, $array);
	}

}

