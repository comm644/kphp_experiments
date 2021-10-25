<?php


namespace Sigmalab\SimpleReflection;
class TypeName
{
	const Bool = 1;
	const Array = 2;
	const Object = 3;
	const String = 4;
	const Int = 5;
	const Float = 6;
	const Mixed = 7;

	public string $name;
	public int $type;
	public static TypeName $intValue;
	public static TypeName $intArray;
	public static TypeName $stringValue;
	public static TypeName $stringArray;
	public static TypeName $boolValue;
	public static TypeName $boolArray;
	public static TypeName $floatValue;
	public static TypeName $floatArray;
	public static TypeName $mixedArray;
	public static TypeName $mixedValue;

	/**
	 * TypeName constructor.
	 * @param string $name
	 * @param int $type
	 */
	public function __construct(string $name, int $type)
	{
		$this->name = $name;
		$this->type = $type;
	}

	public function toString()
	{
		return "typename $this->name type $this->type";
	}
	public static function init()
	{
		self::$intValue = new TypeName('int', TypeName::Int);
		self::$intArray = new TypeName('int', TypeName::Array);
		self::$stringValue = new TypeName('string', TypeName::String);
		self::$stringArray = new TypeName('string', TypeName::Array);
		self::$boolValue = new TypeName('bool', TypeName::Bool);
		self::$boolArray = new TypeName('bool', TypeName::Array);
		self::$floatValue = new TypeName('float', TypeName::Float);
		self::$floatArray = new TypeName('float', TypeName::Array);
		self::$mixedArray = new TypeName('mixed', TypeName::Mixed);
		self::$mixedValue = new TypeName('mixed', TypeName::Array);
	}
}

