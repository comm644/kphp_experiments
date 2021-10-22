How to create self own Reflection for KPHP
Not faster but work.

To enable reflection register reflection classes and registry:
<pre>
ClassRegistry::init();
A_reflection::registerClass();
B_reflection::registerClass();
</pre>

after generation will be available next calls: 

instead:
<pre>
 $object->$name = "other value";
</pre>
use:
<pre>

$ref = ClassRegistry::createReflection(get_class($object) . "_reflection", $object);
$ref->setPropertyValue($name, 'other value');
</pre>

instead:
<pre>
 echo $object->$name;
</pre>

use:
<pre>
$ref = ClassRegistry::createReflection(get_class($object) . "_reflection", $object);
echo $ref->getPropertyValue($name);
</pre>


Decode json:
<pre>
$object = JsonParser::jsonDecodeObject('{"name":"text", "value":10}', Class::class );
</pre>


This approach can be useful for reading json to object to override KPHP limitations
https://vkcom.github.io/kphp/kphp-language/howto-by-kphp/json-encode-decode.html


