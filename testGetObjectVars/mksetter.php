<?php

#ifndef KPHP
spl_autoload_register(function (string $class_name) {
	$filename   = $class_name . '.php';
    require_once( $filename );
});

$className = $argv[1];

echo <<<TEXT
<?php

//autogenerated
trait {$className}_reflection
{
	/**
	 * @kphp-required
	 * @param string \$name
	 * @param mixed \$value
	 */
	public function setPropertyValue(string \$name, \$value)
	{
		//autogenerated map
		switch (\$name) {

TEXT;

foreach (get_object_vars(new $className) as $key=>$value ) {
	$type = gettype($value);
	if ( $type === "integer" ) $type ="int";
	
		echo <<<TEXT
			case '$key': \$this->$key = ($type)\$value; break;

TEXT;
}
echo <<<TEXT
		}
	}

	/**
	 * @kphp-required
	 * @param string \$name
	 * @return mixed 
	 */
	public function getPropertyValue(string \$name)
	{
		//autogenerated map
		switch (\$name) {

TEXT;

foreach (get_object_vars(new $className) as $key=>$value ) {
	$type = gettype($value);
	echo <<<TEXT
			case '$key': return \$this->$key;

TEXT;
}
echo <<<TEXT
		}
		return null;
	}
}

TEXT;



#endif

