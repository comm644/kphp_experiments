How to create self own Reflection for KPHP
Not faster but work.

## Initialize

To enable reflection need to register reflection classes and registry:
```php
ClassRegistry::init();
A_reflection::registerClass();
B_reflection::registerClass();
```
Add interface to target class:
```php
class A implements IReflectedObject {... }
class B implements IReflectedObject {... }
```
We must have common base class instead 'object' to avoid type inferring.


after generation will be available next calls: 

## Set Property Value
instead:
```php
 $object->$name = "other value";
```
use:

```php
$ref = ClassRegistry::createReflection(get_class($object), $object);
$ref->setPropertyValue($name, 'other value');
```

## Get Property value
instead:
```php
 echo $object->$name;
```

use:
```php
$ref = ClassRegistry::createReflection(get_class($object), $object);
echo $ref->getPropertyValue($name);
```

## Invoke method

instead:
```php
$method = "set_".$name;
$object->$method( "value" );
```

use:
```php
$ref = ClassRegistry::createReflection(get_class($object), $object);
$ref->callMethod("set_".$key, [new ValueScalar($value)]);
```

## Decode json

Decode json:
```php
$object = JsonParser::jsonDecodeObject('{"name":"text", "value":10}', Class::class );
```


This approach can be useful for reading json to object to override KPHP limitations
https://vkcom.github.io/kphp/kphp-language/howto-by-kphp/json-encode-decode.html


# How it works

1. Autogenerating mappng "name - property/method"
2. Boxing/unboxing values. we must have common grond for every type.


