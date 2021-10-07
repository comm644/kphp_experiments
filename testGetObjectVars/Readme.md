How to create self own Reflection for KPHP
Not faster but work.

Supports next calls: 

instead:
<pre>
 $object->$name = "other value";
</pre>
use:
<pre>
 ClassName_reflection::setPropertyValue($object, $name, 'other value');
</pre>

instead:
<pre>
 echo $object->$name;
</pre>

use:
<pre>
 echo ClassName_reflection::getPropertyValue($object, $name);
</pre>
