<?php

#ifndef KPHP

spl_autoload_register(function (string $class_name) {
	$filename = str_replace('\\', '/', $class_name) . '.php';
    require_once( $filename );
});

/**
 * @param object $object
 * @param $propertyName
 * @param $m
 * @return array
 * @throws \ReflectionException
 */
function getArrayItemClassName(object $object, string $propertyName): array
{
	$ref = new \ReflectionClass(get_class($object));
	$prop = $ref->getProperty($propertyName);
	preg_match("/@var\s+([A-Za-z_]+)(\[\])?/", $prop->getDocComment(), $m);
	$itemClassName = $m[1];
	if  (count($m) == 3) {
		return array($itemClassName, true);
	}
	return array($itemClassName, false);
}


$className = $argv[1];
$object = new $className;
$className = get_class($object);

echo <<<TEXT
<?php

//autogenerated
class {$className}_reflection implements \SimpleReflection\ICanReflection
{
	/** ${className} */
	private ${className} \$instance;
	
	public function __construct(${className} \$instance) 
	{
		\$this->instance = \$instance;
	}
	/**
	 * @kphp-required
	 * @param string \$name
	 * @return \SimpleReflection\TypeName
	 */
	public function getPropertyType(string \$name) : \SimpleReflection\TypeName
	{
		//autogenerated map
		switch (\$name) {

TEXT;

$declareType = [];
$declareInit = [];
foreach (get_object_vars($object) as $key=> $value ) {

	list($decl, $isArray) = getArrayItemClassName($object, $key );

	if ( $isArray) {
		switch ($decl) {
			case 'int': $code = '\SimpleReflection\TypeName::$intArray'; break;
			case 'integer': $code = '\SimpleReflection\TypeName::$intArray'; break;
			case 'string': $code = '\SimpleReflection\TypeName::$stringArray'; break;
			case 'bool': $code = '\SimpleReflection\TypeName::$boolArray'; break;
			case 'float': $code = '\SimpleReflection\TypeName::$floatArray'; break;
			default:
				$declareType[] = "private static \SimpleReflection\TypeName \${$key}_type;";
				$declareInit[] = "self::\${$key}_type = new \SimpleReflection\TypeName('$decl', \SimpleReflection\TypeName::Array );";
				$code = "self::\${$key}_type";
				break;
		}
	}
	else {
		switch ($decl) {
			case 'int':$code = '\SimpleReflection\TypeName::$intValue';break;
			case 'integer':$code = '\SimpleReflection\TypeName::$intValue';break;
			case 'string':$code = '\SimpleReflection\TypeName::$stringValue';break;
			case 'bool':$code = '\SimpleReflection\TypeName::$boolValue';break;
			case 'float':$code = '\SimpleReflection\TypeName::$floatValue';break;
			default:
				$declareType[] = "private static \SimpleReflection\TypeName \${$key}_type;";
				$declareInit[] = "self::\${$key}_type = new \SimpleReflection\TypeName('$decl', \SimpleReflection\TypeName::Object );";
				$code = "self::\${$key}_type";
				break;
		}
	}
	echo <<<TEXT
			case '$key': return $code;

TEXT;
}
echo <<<TEXT
		}             
		return \SimpleReflection\TypeName::\$intValue;
	}
	

	/**
	 * @kphp-required
	 * @param string \$name
	 * @param \SimpleReflection\MixedValue \$value
	 */
	public function setPropertyValue(string \$name, \SimpleReflection\MixedValue \$value) : void
	{
		//autogenerated map
		switch (\$name) {

TEXT;

foreach (get_object_vars($object) as $key=> $value ) {
	list($decl, $isArray) = getArrayItemClassName($object, $key );
	$type = gettype($value);
	if ( $type === "integer" ) $type ="int";

	echo <<<TEXT
		case '$key':

TEXT;

	if ( $isArray) {
		switch ($decl) {
			case 'int':
			case 'integer':
			case 'string':
			case 'bool':
			case 'float':
				echo <<<TEXT
				\$this->instance->$key = [];
				if (\$value instanceof \SimpleReflection\ScalarArrayValue) {
					foreach (\$value->getValue() as \$arrayValue) {
						\$this->instance->{$key}[] =  ($decl) \$arrayValue;
					}
				}

TEXT;
				break;
			default:
				echo <<<TEXT
				\$this->instance->$key = [];
				if (\$value instanceof \SimpleReflection\ArrayValue) {
					foreach (\$value->getValue() as \$arrayValue) {
						\$this->instance->{$key}[] =  instance_cast(\$arrayValue, $decl::class);
					}
				}

TEXT;
				break;
		}
	}
	else {
		switch ($decl) {
			case 'int':
			case 'integer':
			case 'string':
			case 'bool':
			case 'float':
			echo <<<TEXT
			if (\$value instanceof \SimpleReflection\ScalarValue) {
				\$this->instance->$key = ($type)\$value->getValue();
			}


TEXT;
			break;

			default:
				echo <<<TEXT
			if ( \$value instanceof \SimpleReflection\ObjectValue ) {
				\$this->instance->$key = instance_cast(\$value->getValue(), $decl::class); 
			}

TEXT;
				break;
		}
	}
	echo <<<TEXT
			break;

TEXT;
}
echo <<<TEXT
		}
	}

	/**
	 * @kphp-required
	 * @param string \$name
	 * @return \SimpleReflection\MixedValue 
	 */
	public function getPropertyValue(string \$name) :\SimpleReflection\MixedValue
	{
		//autogenerated map
		switch (\$name) {

TEXT;

foreach (get_object_vars($object) as $key=> $value ) {

	list($decl, $isArray) = getArrayItemClassName($object, $key );

	if ( $isArray) {
		switch ($decl) {
			case 'int':
			case 'integer':
			case 'string':
			case 'bool':
			case 'float':
				$code = "return new \SimpleReflection\ScalarArrayValue( \$this->instance->$key )";
				break;
			default:
				$code = "return new \SimpleReflection\ArrayValue( \$this->instance->$key )";
				break;
		}
	}
	else {
		switch ($decl) {
			case 'int':
			case 'integer':
			case 'string':
			case 'bool':
			case 'float':
				$code = "return new \SimpleReflection\ScalarValue( \$this->instance->$key )";
				break;
			default:
				$code = "return new \SimpleReflection\ObjectValue( \$this->instance->$key )";
				break;
		}
	}
	echo <<<TEXT
			case '$key': {$code}  /*$decl*/;

TEXT;
}
echo <<<TEXT
		}
		return null;
	}
	
TEXT;

$declaredTypes = implode("\n	", $declareType);
$declaredInit = implode("\n		", $declareInit);
echo <<<TEXT

	public static function registerClass()
	{   
		\SimpleReflection\ClassRegistry::registerClass('{$className}', function(){ return new $className; });
		\SimpleReflection\ClassRegistry::registerReflection('{$className}_reflection', function(object \$instance){ 
			return new {$className}_reflection(instance_cast(\$instance, ${className}::class)); 
		});
		{$declaredInit}
	}
	{$declaredTypes}
}

TEXT;



#endif

