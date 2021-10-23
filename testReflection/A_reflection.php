<?php

//autogenerated
class A_reflection implements \Sigmalab\SimpleReflection\ICanReflection
{
	/** A */
	private A $instance;
	
	public function __construct(A $instance) 
	{
		$this->instance = $instance;
	}	
	/**
	 * @kphp-required
	 * @param string $name
	 * @return \Sigmalab\SimpleReflection\TypeName
	 */
	public function getPropertyType(string $name) : \Sigmalab\SimpleReflection\TypeName
	{
		//autogenerated map
		switch ($name) {
			case 'name': return \Sigmalab\SimpleReflection\TypeName::$stringValue;
			case 'value': return \Sigmalab\SimpleReflection\TypeName::$intValue;
			case 'myarray': return \Sigmalab\SimpleReflection\TypeName::$intArray;
			case 'stringArray': return \Sigmalab\SimpleReflection\TypeName::$stringArray;
			case 'floatArray': return \Sigmalab\SimpleReflection\TypeName::$floatArray;
			case 'boolArray': return \Sigmalab\SimpleReflection\TypeName::$boolArray;
			case 'arrayB': return self::$arrayB_type;
			case 'valueB': return self::$valueB_type;
		}             
		return \Sigmalab\SimpleReflection\TypeName::$intValue;
	}
	

	/**
	 * @kphp-required
	 * @param string $name
	 * @param \Sigmalab\SimpleReflection\ValueMixed $value
	 */
	public function setPropertyValue(string $name, \Sigmalab\SimpleReflection\ValueMixed $value) : void
	{
		//autogenerated map
		switch ($name) {
		case 'name':
			if ($value instanceof \Sigmalab\SimpleReflection\ValueScalar) {
				$this->instance->name = (string)$value->getValue();
			}

			break;
		case 'value':
			if ($value instanceof \Sigmalab\SimpleReflection\ValueScalar) {
				$this->instance->value = (int)$value->getValue();
			}

			break;
		case 'myarray':
				if ($value instanceof \Sigmalab\SimpleReflection\ValueScalars) {
					$this->instance->myarray  = $value->get_as_int();
				}
			break;
		case 'stringArray':
				if ($value instanceof \Sigmalab\SimpleReflection\ValueScalars) {
					$this->instance->stringArray  = $value->get_as_string();
				}
			break;
		case 'floatArray':
				if ($value instanceof \Sigmalab\SimpleReflection\ValueScalars) {
					$this->instance->floatArray  = $value->get_as_float();
				}
			break;
		case 'boolArray':
				if ($value instanceof \Sigmalab\SimpleReflection\ValueScalars) {
					$this->instance->boolArray  = $value->get_as_bool();
				}
			break;
		case 'arrayB':
				$this->instance->arrayB = [];
				if ($value instanceof \Sigmalab\SimpleReflection\ValueObjects) {
					foreach ($value->getValue() as $arrayValue) {
						$this->instance->arrayB[] =  instance_cast($arrayValue, B::class);
					}
				}
			break;
		case 'valueB':
			if ( $value instanceof \Sigmalab\SimpleReflection\ValueObject ) {
				$this->instance->valueB = instance_cast($value->getValue(), B::class); 
			}
			break;
		}
	}

	/**
	 * @kphp-required
	 * @param string $name
	 * @return \Sigmalab\SimpleReflection\ValueMixed
	 */
	public function getPropertyValue(string $name) :\Sigmalab\SimpleReflection\ValueMixed
	{
		//autogenerated map
		switch ($name) {
			case 'name': return new \Sigmalab\SimpleReflection\ValueScalar( $this->instance->name );
			case 'value': return new \Sigmalab\SimpleReflection\ValueScalar( $this->instance->value );
			case 'myarray': return new \Sigmalab\SimpleReflection\ValueScalars( $this->instance->myarray );
			case 'stringArray': return new \Sigmalab\SimpleReflection\ValueScalars( $this->instance->stringArray );
			case 'floatArray': return new \Sigmalab\SimpleReflection\ValueScalars( $this->instance->floatArray );
			case 'boolArray': return new \Sigmalab\SimpleReflection\ValueScalars( $this->instance->boolArray );
			case 'arrayB': return new \Sigmalab\SimpleReflection\ValueObjects( $this->instance->arrayB );
			case 'valueB': return new \Sigmalab\SimpleReflection\ValueObject( $this->instance->valueB );
		}
		return null;
	}
	
	public static function registerClass()
	{   
		\Sigmalab\SimpleReflection\ClassRegistry::registerClass('A', function(){ return new A; });
		\Sigmalab\SimpleReflection\ClassRegistry::registerReflection('A_reflection', function(object $instance){ 
			return new A_reflection(instance_cast($instance, A::class)); 
		});
		self::$arrayB_type = new \Sigmalab\SimpleReflection\TypeName('B', \Sigmalab\SimpleReflection\TypeName::Array );
		self::$valueB_type = new \Sigmalab\SimpleReflection\TypeName('B', \Sigmalab\SimpleReflection\TypeName::Object );
	}
	private static \Sigmalab\SimpleReflection\TypeName $arrayB_type;
	private static \Sigmalab\SimpleReflection\TypeName $valueB_type;
	/**
	 * @param string $methodName
	 * @param \Sigmalab\SimpleReflection\ValueMixed[] $args
	 */
	public function callMethod(string $methodName, array $args) :void
	{
		switch ($methodName)
		{
		}
	}
}