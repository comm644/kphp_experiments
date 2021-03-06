<?php

//autogenerated
class B_reflection implements \SimpleReflection\ICanReflection
{
	/** B */
	private B $instance;
	
	public function __construct(B $instance) 
	{
		$this->instance = $instance;
	}
	/**
	 * @kphp-required
	 * @param string $name
	 * @return \SimpleReflection\TypeName
	 */
	public function getPropertyType(string $name) : \SimpleReflection\TypeName
	{
		//autogenerated map
		switch ($name) {
			case 'other': return \SimpleReflection\TypeName::$stringValue;
		}             
		return \SimpleReflection\TypeName::$intValue;
	}
	

	/**
	 * @kphp-required
	 * @param string $name
	 * @param \SimpleReflection\MixedValue $value
	 */
	public function setPropertyValue(string $name, \SimpleReflection\MixedValue $value) : void
	{
		//autogenerated map
		switch ($name) {
		case 'other':
			if ($value instanceof \SimpleReflection\ScalarValue) {
				$this->instance->other = (string)$value->getValue();
			}

			break;
		}
	}

	/**
	 * @kphp-required
	 * @param string $name
	 * @return \SimpleReflection\MixedValue 
	 */
	public function getPropertyValue(string $name) :\SimpleReflection\MixedValue
	{
		//autogenerated map
		switch ($name) {
			case 'other': return new \SimpleReflection\ScalarValue( $this->instance->other )  /*string*/;
		}
		return null;
	}
	
	public static function registerClass()
	{   
		\SimpleReflection\ClassRegistry::registerClass('B', function(){ return new B; });
		\SimpleReflection\ClassRegistry::registerReflection('B_reflection', function(object $instance){ 
			return new B_reflection(instance_cast($instance, B::class)); 
		});
		
	}
	
}
