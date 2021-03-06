<?php
namespace Database;


use Sigmalab\SimpleReflection\IReflectedObject;

//autogenerated
class Document_reflection implements \Sigmalab\SimpleReflection\ICanReflection
{
	/** Document */
	private Document $instance;
	
	public function __construct(Document $instance) 
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
			case 'documentId': return \Sigmalab\SimpleReflection\TypeName::$intValue;
			case 'documentType': return \Sigmalab\SimpleReflection\TypeName::$intValue;
			case 'documentKey': return \Sigmalab\SimpleReflection\TypeName::$stringValue;
			case 'documentTitle': return \Sigmalab\SimpleReflection\TypeName::$stringValue;
			case 'documentContent': return \Sigmalab\SimpleReflection\TypeName::$stringValue;
			case 'documentTag': return \Sigmalab\SimpleReflection\TypeName::$stringValue;
			case 'documentVersion': return \Sigmalab\SimpleReflection\TypeName::$intValue;
			case 'documentDateCreated': return \Sigmalab\SimpleReflection\TypeName::$intValue;
			case 'documentDateChanged': return \Sigmalab\SimpleReflection\TypeName::$intValue;
			case 'documentDateDeleted': return \Sigmalab\SimpleReflection\TypeName::$intValue;
			case 'documentState': return \Sigmalab\SimpleReflection\TypeName::$intValue;
			case 'documentAuthor': return \Sigmalab\SimpleReflection\TypeName::$intValue;
			case 'documentMetadata': return \Sigmalab\SimpleReflection\TypeName::$mixedValue;
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
/* int */
		case 'documentId':
			if ($value instanceof \Sigmalab\SimpleReflection\ValueScalar) {
				$this->instance->documentId = $value->get_as_int();
			}

			break;
/* int */
		case 'documentType':
			if ($value instanceof \Sigmalab\SimpleReflection\ValueScalar) {
				$this->instance->documentType = $value->get_as_int();
			}

			break;
/* string */
		case 'documentKey':
			if ($value instanceof \Sigmalab\SimpleReflection\ValueScalar) {
				$this->instance->documentKey = $value->get_as_string();
			}

			break;
/* string */
		case 'documentTitle':
			if ($value instanceof \Sigmalab\SimpleReflection\ValueScalar) {
				$this->instance->documentTitle = $value->get_as_string();
			}

			break;
/* string */
		case 'documentContent':
			if ($value instanceof \Sigmalab\SimpleReflection\ValueScalar) {
				$this->instance->documentContent = $value->get_as_string();
			}

			break;
/* string */
		case 'documentTag':
			if ($value instanceof \Sigmalab\SimpleReflection\ValueScalar) {
				$this->instance->documentTag = $value->get_as_string();
			}

			break;
/* int */
		case 'documentVersion':
			if ($value instanceof \Sigmalab\SimpleReflection\ValueScalar) {
				$this->instance->documentVersion = $value->get_as_int();
			}

			break;
/* int */
		case 'documentDateCreated':
			if ($value instanceof \Sigmalab\SimpleReflection\ValueScalar) {
				$this->instance->documentDateCreated = $value->get_as_int();
			}

			break;
/* int */
		case 'documentDateChanged':
			if ($value instanceof \Sigmalab\SimpleReflection\ValueScalar) {
				$this->instance->documentDateChanged = $value->get_as_int();
			}

			break;
/* int */
		case 'documentDateDeleted':
			if ($value instanceof \Sigmalab\SimpleReflection\ValueScalar) {
				$this->instance->documentDateDeleted = $value->get_as_int();
			}

			break;
/* int */
		case 'documentState':
			if ($value instanceof \Sigmalab\SimpleReflection\ValueScalar) {
				$this->instance->documentState = $value->get_as_int();
			}

			break;
/* int */
		case 'documentAuthor':
			if ($value instanceof \Sigmalab\SimpleReflection\ValueScalar) {
				$this->instance->documentAuthor = $value->get_as_int();
			}

			break;
/* mixed */
		case 'documentMetadata':
			if ($value instanceof \Sigmalab\SimpleReflection\ValueScalar) {
				$this->instance->documentMetadata = $value->get_as_mixed();
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
			case 'documentId': return new \Sigmalab\SimpleReflection\ValueScalar( $this->instance->documentId );
			case 'documentType': return new \Sigmalab\SimpleReflection\ValueScalar( $this->instance->documentType );
			case 'documentKey': return new \Sigmalab\SimpleReflection\ValueScalar( $this->instance->documentKey );
			case 'documentTitle': return new \Sigmalab\SimpleReflection\ValueScalar( $this->instance->documentTitle );
			case 'documentContent': return new \Sigmalab\SimpleReflection\ValueScalar( $this->instance->documentContent );
			case 'documentTag': return new \Sigmalab\SimpleReflection\ValueScalar( $this->instance->documentTag );
			case 'documentVersion': return new \Sigmalab\SimpleReflection\ValueScalar( $this->instance->documentVersion );
			case 'documentDateCreated': return new \Sigmalab\SimpleReflection\ValueScalar( $this->instance->documentDateCreated );
			case 'documentDateChanged': return new \Sigmalab\SimpleReflection\ValueScalar( $this->instance->documentDateChanged );
			case 'documentDateDeleted': return new \Sigmalab\SimpleReflection\ValueScalar( $this->instance->documentDateDeleted );
			case 'documentState': return new \Sigmalab\SimpleReflection\ValueScalar( $this->instance->documentState );
			case 'documentAuthor': return new \Sigmalab\SimpleReflection\ValueScalar( $this->instance->documentAuthor );
			case 'documentMetadata': return new \Sigmalab\SimpleReflection\ValueScalar( $this->instance->documentMetadata );
		}
		return null;
	}
	
	public static function registerClass()
	{   
		\Sigmalab\SimpleReflection\ClassRegistry::registerClass('Database\Document', function(){ return new Document; });
		\Sigmalab\SimpleReflection\ClassRegistry::registerReflection('Database\Document_reflection', function(object $instance){
			return new Document_reflection(instance_cast($instance, Document::class)); 
		});
		
	}
	

	/**
	* @return mixed
	*/
	public function invoke_as_mixed(string $methodName, array $args) 
	{
		return 0;
	}
	public function invoke_as_object(string $methodName, array $args) :?IReflectedObject
	{
		return null;
	}

	/**
	 * @param string $methodName
	 * @param \Sigmalab\SimpleReflection\ValueMixed[] $args
	 * @throws \Exception
	 */
	public function invoke_as_void(string $methodName, array $args) :void
	{
		switch ($methodName)
		{
			case 'getDocumentPrototype':
				$this->invoke_getDocumentPrototype($args);
				break;
			case 'primary_key':
				$this->invoke_primary_key($args);
				break;
			case 'primary_key_value':
				$this->invoke_primary_key_value($args);
				break;
			case 'table_name':
				$this->invoke_table_name($args);
				break;
			case 'table_description':
				$this->invoke_table_description($args);
				break;
			case 'getColumnDefinition':
				$this->invoke_getColumnDefinition($args);
				break;
			case 'getForeignKeys':
				$this->invoke_getForeignKeys($args);
				break;
			case 'isNew':
				$this->invoke_isNew($args);
				break;
			case 'set_documentId':
				$this->invoke_set_documentId($args);
				break;
			case 'get_documentId':
				$this->invoke_get_documentId($args);
				break;
			case 'set_documentType':
				$this->invoke_set_documentType($args);
				break;
			case 'get_documentType':
				$this->invoke_get_documentType($args);
				break;
			case 'set_documentKey':
				$this->invoke_set_documentKey($args);
				break;
			case 'get_documentKey':
				$this->invoke_get_documentKey($args);
				break;
			case 'set_documentTitle':
				$this->invoke_set_documentTitle($args);
				break;
			case 'get_documentTitle':
				$this->invoke_get_documentTitle($args);
				break;
			case 'set_documentContent':
				$this->invoke_set_documentContent($args);
				break;
			case 'get_documentContent':
				$this->invoke_get_documentContent($args);
				break;
			case 'set_documentTag':
				$this->invoke_set_documentTag($args);
				break;
			case 'get_documentTag':
				$this->invoke_get_documentTag($args);
				break;
			case 'set_documentVersion':
				$this->invoke_set_documentVersion($args);
				break;
			case 'get_documentVersion':
				$this->invoke_get_documentVersion($args);
				break;
			case 'set_documentDateCreated':
				$this->invoke_set_documentDateCreated($args);
				break;
			case 'get_documentDateCreated':
				$this->invoke_get_documentDateCreated($args);
				break;
			case 'set_documentDateChanged':
				$this->invoke_set_documentDateChanged($args);
				break;
			case 'get_documentDateChanged':
				$this->invoke_get_documentDateChanged($args);
				break;
			case 'set_documentDateDeleted':
				$this->invoke_set_documentDateDeleted($args);
				break;
			case 'get_documentDateDeleted':
				$this->invoke_get_documentDateDeleted($args);
				break;
			case 'set_documentState':
				$this->invoke_set_documentState($args);
				break;
			case 'get_documentState':
				$this->invoke_get_documentState($args);
				break;
			case 'set_documentAuthor':
				$this->invoke_set_documentAuthor($args);
				break;
			case 'get_documentAuthor':
				$this->invoke_get_documentAuthor($args);
				break;
			case 'set_documentMetadata':
				$this->invoke_set_documentMetadata($args);
				break;
			case 'get_documentMetadata':
				$this->invoke_get_documentMetadata($args);
				break;
			case 'tag_documentId':
				$this->invoke_tag_documentId($args);
				break;
			case 'tag_documentType':
				$this->invoke_tag_documentType($args);
				break;
			case 'tag_documentKey':
				$this->invoke_tag_documentKey($args);
				break;
			case 'tag_documentTitle':
				$this->invoke_tag_documentTitle($args);
				break;
			case 'tag_documentContent':
				$this->invoke_tag_documentContent($args);
				break;
			case 'tag_documentTag':
				$this->invoke_tag_documentTag($args);
				break;
			case 'tag_documentVersion':
				$this->invoke_tag_documentVersion($args);
				break;
			case 'tag_documentDateCreated':
				$this->invoke_tag_documentDateCreated($args);
				break;
			case 'tag_documentDateChanged':
				$this->invoke_tag_documentDateChanged($args);
				break;
			case 'tag_documentDateDeleted':
				$this->invoke_tag_documentDateDeleted($args);
				break;
			case 'tag_documentState':
				$this->invoke_tag_documentState($args);
				break;
			case 'tag_documentAuthor':
				$this->invoke_tag_documentAuthor($args);
				break;
			case 'tag_documentMetadata':
				$this->invoke_tag_documentMetadata($args);
				break;
			case 'prototypeMap':
				$this->invoke_prototypeMap($args);
				break;
			case 'key_documentAuthor':
				$this->invoke_key_documentAuthor($args);
				break;
			case 'getTableAlias':
				$this->invoke_getTableAlias($args);
				break;
			case 'setValue':
				$this->invoke_setValue($args);
				break;
		}
	}

	/**
	 * @param \Sigmalab\SimpleReflection\ValueMixed[] $args
	 * @throws \Exception
	 */
	private function invoke_getDocumentPrototype(array $args)
	{

		/** @var string $arg0 */      
		$value0 = $args[0];
		if ( $value0 instanceof \Sigmalab\SimpleReflection\ValueScalar) $arg0 = $value0->get_as_string();
		else throw new \Exception("Invalid argument 0");

		$this->instance->getDocumentPrototype($arg0);
	}

	/**
	 * @param \Sigmalab\SimpleReflection\ValueMixed[] $args
	 * @throws \Exception
	 */
	private function invoke_primary_key(array $args)
	{
		$this->instance->primary_key();
	}

	/**
	 * @param \Sigmalab\SimpleReflection\ValueMixed[] $args
	 * @throws \Exception
	 */
	private function invoke_primary_key_value(array $args)
	{
		$this->instance->primary_key_value();
	}

	/**
	 * @param \Sigmalab\SimpleReflection\ValueMixed[] $args
	 * @throws \Exception
	 */
	private function invoke_table_name(array $args)
	{
		$this->instance->table_name();
	}

	/**
	 * @param \Sigmalab\SimpleReflection\ValueMixed[] $args
	 * @throws \Exception
	 */
	private function invoke_table_description(array $args)
	{
		$this->instance->table_description();
	}

	/**
	 * @param \Sigmalab\SimpleReflection\ValueMixed[] $args
	 * @throws \Exception
	 */
	private function invoke_getColumnDefinition(array $args)
	{
		$this->instance->getColumnDefinition();
	}

	/**
	 * @param \Sigmalab\SimpleReflection\ValueMixed[] $args
	 * @throws \Exception
	 */
	private function invoke_getForeignKeys(array $args)
	{
		$this->instance->getForeignKeys();
	}

	/**
	 * @param \Sigmalab\SimpleReflection\ValueMixed[] $args
	 * @throws \Exception
	 */
	private function invoke_isNew(array $args)
	{
		$this->instance->isNew();
	}

	/**
	 * @param \Sigmalab\SimpleReflection\ValueMixed[] $args
	 * @throws \Exception
	 */
	private function invoke_set_documentId(array $args)
	{

		/** @var int $arg0 */      
		$value0 = $args[0];
		if ( $value0 instanceof \Sigmalab\SimpleReflection\ValueScalar) $arg0 = $value0->get_as_int();
		else throw new \Exception("Invalid argument 0");

		$this->instance->set_documentId($arg0);
	}

	/**
	 * @param \Sigmalab\SimpleReflection\ValueMixed[] $args
	 * @throws \Exception
	 */
	private function invoke_get_documentId(array $args)
	{
		$this->instance->get_documentId();
	}

	/**
	 * @param \Sigmalab\SimpleReflection\ValueMixed[] $args
	 * @throws \Exception
	 */
	private function invoke_set_documentType(array $args)
	{

		/** @var int $arg0 */      
		$value0 = $args[0];
		if ( $value0 instanceof \Sigmalab\SimpleReflection\ValueScalar) $arg0 = $value0->get_as_int();
		else throw new \Exception("Invalid argument 0");

		$this->instance->set_documentType($arg0);
	}

	/**
	 * @param \Sigmalab\SimpleReflection\ValueMixed[] $args
	 * @throws \Exception
	 */
	private function invoke_get_documentType(array $args)
	{
		$this->instance->get_documentType();
	}

	/**
	 * @param \Sigmalab\SimpleReflection\ValueMixed[] $args
	 * @throws \Exception
	 */
	private function invoke_set_documentKey(array $args)
	{

		/** @var string $arg0 */      
		$value0 = $args[0];
		if ( $value0 instanceof \Sigmalab\SimpleReflection\ValueScalar) $arg0 = $value0->get_as_string();
		else throw new \Exception("Invalid argument 0");

		$this->instance->set_documentKey($arg0);
	}

	/**
	 * @param \Sigmalab\SimpleReflection\ValueMixed[] $args
	 * @throws \Exception
	 */
	private function invoke_get_documentKey(array $args)
	{
		$this->instance->get_documentKey();
	}

	/**
	 * @param \Sigmalab\SimpleReflection\ValueMixed[] $args
	 * @throws \Exception
	 */
	private function invoke_set_documentTitle(array $args)
	{

		/** @var string $arg0 */      
		$value0 = $args[0];
		if ( $value0 instanceof \Sigmalab\SimpleReflection\ValueScalar) $arg0 = $value0->get_as_string();
		else throw new \Exception("Invalid argument 0");

		$this->instance->set_documentTitle($arg0);
	}

	/**
	 * @param \Sigmalab\SimpleReflection\ValueMixed[] $args
	 * @throws \Exception
	 */
	private function invoke_get_documentTitle(array $args)
	{
		$this->instance->get_documentTitle();
	}

	/**
	 * @param \Sigmalab\SimpleReflection\ValueMixed[] $args
	 * @throws \Exception
	 */
	private function invoke_set_documentContent(array $args)
	{

		/** @var string $arg0 */      
		$value0 = $args[0];
		if ( $value0 instanceof \Sigmalab\SimpleReflection\ValueScalar) $arg0 = $value0->get_as_string();
		else throw new \Exception("Invalid argument 0");

		$this->instance->set_documentContent($arg0);
	}

	/**
	 * @param \Sigmalab\SimpleReflection\ValueMixed[] $args
	 * @throws \Exception
	 */
	private function invoke_get_documentContent(array $args)
	{
		$this->instance->get_documentContent();
	}

	/**
	 * @param \Sigmalab\SimpleReflection\ValueMixed[] $args
	 * @throws \Exception
	 */
	private function invoke_set_documentTag(array $args)
	{

		/** @var string $arg0 */      
		$value0 = $args[0];
		if ( $value0 instanceof \Sigmalab\SimpleReflection\ValueScalar) $arg0 = $value0->get_as_string();
		else throw new \Exception("Invalid argument 0");

		$this->instance->set_documentTag($arg0);
	}

	/**
	 * @param \Sigmalab\SimpleReflection\ValueMixed[] $args
	 * @throws \Exception
	 */
	private function invoke_get_documentTag(array $args)
	{
		$this->instance->get_documentTag();
	}

	/**
	 * @param \Sigmalab\SimpleReflection\ValueMixed[] $args
	 * @throws \Exception
	 */
	private function invoke_set_documentVersion(array $args)
	{

		/** @var int $arg0 */      
		$value0 = $args[0];
		if ( $value0 instanceof \Sigmalab\SimpleReflection\ValueScalar) $arg0 = $value0->get_as_int();
		else throw new \Exception("Invalid argument 0");

		$this->instance->set_documentVersion($arg0);
	}

	/**
	 * @param \Sigmalab\SimpleReflection\ValueMixed[] $args
	 * @throws \Exception
	 */
	private function invoke_get_documentVersion(array $args)
	{
		$this->instance->get_documentVersion();
	}

	/**
	 * @param \Sigmalab\SimpleReflection\ValueMixed[] $args
	 * @throws \Exception
	 */
	private function invoke_set_documentDateCreated(array $args)
	{

		/** @var int $arg0 */      
		$value0 = $args[0];
		if ( $value0 instanceof \Sigmalab\SimpleReflection\ValueScalar) $arg0 = $value0->get_as_int();
		else throw new \Exception("Invalid argument 0");

		$this->instance->set_documentDateCreated($arg0);
	}

	/**
	 * @param \Sigmalab\SimpleReflection\ValueMixed[] $args
	 * @throws \Exception
	 */
	private function invoke_get_documentDateCreated(array $args)
	{
		$this->instance->get_documentDateCreated();
	}

	/**
	 * @param \Sigmalab\SimpleReflection\ValueMixed[] $args
	 * @throws \Exception
	 */
	private function invoke_set_documentDateChanged(array $args)
	{

		/** @var int $arg0 */      
		$value0 = $args[0];
		if ( $value0 instanceof \Sigmalab\SimpleReflection\ValueScalar) $arg0 = $value0->get_as_int();
		else throw new \Exception("Invalid argument 0");

		$this->instance->set_documentDateChanged($arg0);
	}

	/**
	 * @param \Sigmalab\SimpleReflection\ValueMixed[] $args
	 * @throws \Exception
	 */
	private function invoke_get_documentDateChanged(array $args)
	{
		$this->instance->get_documentDateChanged();
	}

	/**
	 * @param \Sigmalab\SimpleReflection\ValueMixed[] $args
	 * @throws \Exception
	 */
	private function invoke_set_documentDateDeleted(array $args)
	{

		/** @var int $arg0 */      
		$value0 = $args[0];
		if ( $value0 instanceof \Sigmalab\SimpleReflection\ValueScalar) $arg0 = $value0->get_as_int();
		else throw new \Exception("Invalid argument 0");

		$this->instance->set_documentDateDeleted($arg0);
	}

	/**
	 * @param \Sigmalab\SimpleReflection\ValueMixed[] $args
	 * @throws \Exception
	 */
	private function invoke_get_documentDateDeleted(array $args)
	{
		$this->instance->get_documentDateDeleted();
	}

	/**
	 * @param \Sigmalab\SimpleReflection\ValueMixed[] $args
	 * @throws \Exception
	 */
	private function invoke_set_documentState(array $args)
	{

		/** @var int $arg0 */      
		$value0 = $args[0];
		if ( $value0 instanceof \Sigmalab\SimpleReflection\ValueScalar) $arg0 = $value0->get_as_int();
		else throw new \Exception("Invalid argument 0");

		$this->instance->set_documentState($arg0);
	}

	/**
	 * @param \Sigmalab\SimpleReflection\ValueMixed[] $args
	 * @throws \Exception
	 */
	private function invoke_get_documentState(array $args)
	{
		$this->instance->get_documentState();
	}

	/**
	 * @param \Sigmalab\SimpleReflection\ValueMixed[] $args
	 * @throws \Exception
	 */
	private function invoke_set_documentAuthor(array $args)
	{

		/** @var int $arg0 */      
		$value0 = $args[0];
		if ( $value0 instanceof \Sigmalab\SimpleReflection\ValueScalar) $arg0 = $value0->get_as_int();
		else throw new \Exception("Invalid argument 0");

		$this->instance->set_documentAuthor($arg0);
	}

	/**
	 * @param \Sigmalab\SimpleReflection\ValueMixed[] $args
	 * @throws \Exception
	 */
	private function invoke_get_documentAuthor(array $args)
	{
		$this->instance->get_documentAuthor();
	}

	/**
	 * @param \Sigmalab\SimpleReflection\ValueMixed[] $args
	 * @throws \Exception
	 */
	private function invoke_set_documentMetadata(array $args)
	{

		/** @var  $arg0 */      
		$value0 = $args[0];
		if ( $value0 instanceof \Sigmalab\SimpleReflection\ValueScalar) $arg0 = $value0->get_as_mixed();
		else throw new \Exception("Invalid argument 0");

		$this->instance->set_documentMetadata($arg0);
	}

	/**
	 * @param \Sigmalab\SimpleReflection\ValueMixed[] $args
	 * @throws \Exception
	 */
	private function invoke_get_documentMetadata(array $args)
	{
		$this->instance->get_documentMetadata();
	}

	/**
	 * @param \Sigmalab\SimpleReflection\ValueMixed[] $args
	 * @throws \Exception
	 */
	private function invoke_tag_documentId(array $args)
	{

		/** @var string $arg0 */      
		$value0 = $args[0];
		if ( $value0 instanceof \Sigmalab\SimpleReflection\ValueScalar) $arg0 = $value0->get_as_string();
		else throw new \Exception("Invalid argument 0");

		$this->instance->tag_documentId($arg0);
	}

	/**
	 * @param \Sigmalab\SimpleReflection\ValueMixed[] $args
	 * @throws \Exception
	 */
	private function invoke_tag_documentType(array $args)
	{

		/** @var string $arg0 */      
		$value0 = $args[0];
		if ( $value0 instanceof \Sigmalab\SimpleReflection\ValueScalar) $arg0 = $value0->get_as_string();
		else throw new \Exception("Invalid argument 0");

		$this->instance->tag_documentType($arg0);
	}

	/**
	 * @param \Sigmalab\SimpleReflection\ValueMixed[] $args
	 * @throws \Exception
	 */
	private function invoke_tag_documentKey(array $args)
	{

		/** @var string $arg0 */      
		$value0 = $args[0];
		if ( $value0 instanceof \Sigmalab\SimpleReflection\ValueScalar) $arg0 = $value0->get_as_string();
		else throw new \Exception("Invalid argument 0");

		$this->instance->tag_documentKey($arg0);
	}

	/**
	 * @param \Sigmalab\SimpleReflection\ValueMixed[] $args
	 * @throws \Exception
	 */
	private function invoke_tag_documentTitle(array $args)
	{

		/** @var string $arg0 */      
		$value0 = $args[0];
		if ( $value0 instanceof \Sigmalab\SimpleReflection\ValueScalar) $arg0 = $value0->get_as_string();
		else throw new \Exception("Invalid argument 0");

		$this->instance->tag_documentTitle($arg0);
	}

	/**
	 * @param \Sigmalab\SimpleReflection\ValueMixed[] $args
	 * @throws \Exception
	 */
	private function invoke_tag_documentContent(array $args)
	{

		/** @var string $arg0 */      
		$value0 = $args[0];
		if ( $value0 instanceof \Sigmalab\SimpleReflection\ValueScalar) $arg0 = $value0->get_as_string();
		else throw new \Exception("Invalid argument 0");

		$this->instance->tag_documentContent($arg0);
	}

	/**
	 * @param \Sigmalab\SimpleReflection\ValueMixed[] $args
	 * @throws \Exception
	 */
	private function invoke_tag_documentTag(array $args)
	{

		/** @var string $arg0 */      
		$value0 = $args[0];
		if ( $value0 instanceof \Sigmalab\SimpleReflection\ValueScalar) $arg0 = $value0->get_as_string();
		else throw new \Exception("Invalid argument 0");

		$this->instance->tag_documentTag($arg0);
	}

	/**
	 * @param \Sigmalab\SimpleReflection\ValueMixed[] $args
	 * @throws \Exception
	 */
	private function invoke_tag_documentVersion(array $args)
	{

		/** @var string $arg0 */      
		$value0 = $args[0];
		if ( $value0 instanceof \Sigmalab\SimpleReflection\ValueScalar) $arg0 = $value0->get_as_string();
		else throw new \Exception("Invalid argument 0");

		$this->instance->tag_documentVersion($arg0);
	}

	/**
	 * @param \Sigmalab\SimpleReflection\ValueMixed[] $args
	 * @throws \Exception
	 */
	private function invoke_tag_documentDateCreated(array $args)
	{

		/** @var string $arg0 */      
		$value0 = $args[0];
		if ( $value0 instanceof \Sigmalab\SimpleReflection\ValueScalar) $arg0 = $value0->get_as_string();
		else throw new \Exception("Invalid argument 0");

		$this->instance->tag_documentDateCreated($arg0);
	}

	/**
	 * @param \Sigmalab\SimpleReflection\ValueMixed[] $args
	 * @throws \Exception
	 */
	private function invoke_tag_documentDateChanged(array $args)
	{

		/** @var string $arg0 */      
		$value0 = $args[0];
		if ( $value0 instanceof \Sigmalab\SimpleReflection\ValueScalar) $arg0 = $value0->get_as_string();
		else throw new \Exception("Invalid argument 0");

		$this->instance->tag_documentDateChanged($arg0);
	}

	/**
	 * @param \Sigmalab\SimpleReflection\ValueMixed[] $args
	 * @throws \Exception
	 */
	private function invoke_tag_documentDateDeleted(array $args)
	{

		/** @var string $arg0 */      
		$value0 = $args[0];
		if ( $value0 instanceof \Sigmalab\SimpleReflection\ValueScalar) $arg0 = $value0->get_as_string();
		else throw new \Exception("Invalid argument 0");

		$this->instance->tag_documentDateDeleted($arg0);
	}

	/**
	 * @param \Sigmalab\SimpleReflection\ValueMixed[] $args
	 * @throws \Exception
	 */
	private function invoke_tag_documentState(array $args)
	{

		/** @var string $arg0 */      
		$value0 = $args[0];
		if ( $value0 instanceof \Sigmalab\SimpleReflection\ValueScalar) $arg0 = $value0->get_as_string();
		else throw new \Exception("Invalid argument 0");

		$this->instance->tag_documentState($arg0);
	}

	/**
	 * @param \Sigmalab\SimpleReflection\ValueMixed[] $args
	 * @throws \Exception
	 */
	private function invoke_tag_documentAuthor(array $args)
	{

		/** @var string $arg0 */      
		$value0 = $args[0];
		if ( $value0 instanceof \Sigmalab\SimpleReflection\ValueScalar) $arg0 = $value0->get_as_string();
		else throw new \Exception("Invalid argument 0");

		$this->instance->tag_documentAuthor($arg0);
	}

	/**
	 * @param \Sigmalab\SimpleReflection\ValueMixed[] $args
	 * @throws \Exception
	 */
	private function invoke_tag_documentMetadata(array $args)
	{

		/** @var string $arg0 */      
		$value0 = $args[0];
		if ( $value0 instanceof \Sigmalab\SimpleReflection\ValueScalar) $arg0 = $value0->get_as_string();
		else throw new \Exception("Invalid argument 0");

		$this->instance->tag_documentMetadata($arg0);
	}

	/**
	 * @param \Sigmalab\SimpleReflection\ValueMixed[] $args
	 * @throws \Exception
	 */
	private function invoke_prototypeMap(array $args)
	{
		$this->instance->prototypeMap();
	}

	/**
	 * @param \Sigmalab\SimpleReflection\ValueMixed[] $args
	 * @throws \Exception
	 */
	private function invoke_key_documentAuthor(array $args)
	{

		/** @var \Sigmalab\Database\Core\IDataObject $arg0 */
		$value0 = $args[0];
		if ( $value0 instanceof \Sigmalab\SimpleReflection\ValueObject) $arg0 = instance_cast($value0, \Sigmalab\Database\Core\IDataObject::class);
		else throw new \Exception("Invalid argument 0");

		$this->instance->key_documentAuthor($arg0);
	}

	/**
	 * @param \Sigmalab\SimpleReflection\ValueMixed[] $args
	 * @throws \Exception
	 */
	private function invoke_getTableAlias(array $args)
	{
		$this->instance->getTableAlias();
	}

	/**
	 * @param \Sigmalab\SimpleReflection\ValueMixed[] $args
	 * @throws \Exception
	 */
	private function invoke_setValue(array $args)
	{

		/** @var string $arg0 */      
		$value0 = $args[0];
		if ( $value0 instanceof \Sigmalab\SimpleReflection\ValueScalar) $arg0 = $value0->get_as_string();
		else throw new \Exception("Invalid argument 0");


		/** @var  $arg1 */      
		$value1 = $args[1];
		if ( $value1 instanceof \Sigmalab\SimpleReflection\ValueScalar) $arg1 = $value1->get_as_mixed();
		else throw new \Exception("Invalid argument 1");

		$this->instance->setValue($arg0,$arg1);
	}
	/**
	 * @param string $name
	 * @param string $value
	 * @throws \Exception
	 */
	public function set_as_string(string  $name, string $value):void
	{
		switch ($name) {
			case 'documentKey': $this->instance->documentKey  = $value; break;
			case 'documentMetadata': $this->instance->documentMetadata  = $value; break;
			default: throw new \Exception("invalid argument: $name");
		}
	}
	/**
	 * @param string $name
	 * @return string
	 * @throws \Exception
	 */
	public function get_as_string(string  $name):string
	{
		switch ($name) {
			case 'documentKey': return $this->instance->documentKey;
			case 'documentMetadata': return $this->instance->documentMetadata;
			default: throw new \Exception("invalid argument: $name");
		}
	}
	/**
	 * @param string $name
	 * @param int $value
	 * @throws \Exception
	 */
	public function set_as_int(string  $name, int $value):void
	{
		switch ($name) {
			case 'documentId': $this->instance->documentId  = $value; break;
			case 'documentType': $this->instance->documentType  = $value; break;
			case 'documentVersion': $this->instance->documentVersion  = $value; break;
			case 'documentState': $this->instance->documentState  = $value; break;
			default: throw new \Exception("invalid argument: $name");
		}
	}
	/**
	 * @param string $name
	 * @return int
	 * @throws \Exception
	 */
	public function get_as_int(string  $name):int
	{
		switch ($name) {
			case 'documentId': return $this->instance->documentId;
			case 'documentType': return $this->instance->documentType;
			case 'documentVersion': return $this->instance->documentVersion;
			case 'documentState': return $this->instance->documentState;
			default: throw new \Exception("invalid argument: $name");
		}
	}
	/**
	 * @param string $name
	 * @param float $value
	 * @throws \Exception
	 */
	public function set_as_float(string  $name, float $value):void
	{
		switch ($name) {
			default: throw new \Exception("invalid argument: $name");
		}
	}
	/**
	 * @param string $name
	 * @return float
	 * @throws \Exception
	 */
	public function get_as_float(string  $name):float
	{
		switch ($name) {
			default: throw new \Exception("invalid argument: $name");
		}
	}
	/**
	 * @param string $name
	 * @param bool $value
	 * @throws \Exception
	 */
	public function set_as_bool(string  $name, bool $value):void
	{
		switch ($name) {
			default: throw new \Exception("invalid argument: $name");
		}
	}
	/**
	 * @param string $name
	 * @return bool
	 * @throws \Exception
	 */
	public function get_as_bool(string  $name):bool
	{
		switch ($name) {
			default: throw new \Exception("invalid argument: $name");
		}
	}
	/**
	 * @param string $name
	 * @throws \Exception
	 */
	public function set_as_null(string  $name):void
	{
		switch ($name) {
			case 'documentId': $this->instance->documentId  = null; break;
			case 'documentTitle': $this->instance->documentTitle  = null; break;
			case 'documentContent': $this->instance->documentContent  = null; break;
			case 'documentTag': $this->instance->documentTag  = null; break;
			case 'documentDateCreated': $this->instance->documentDateCreated  = null; break;
			case 'documentDateChanged': $this->instance->documentDateChanged  = null; break;
			case 'documentDateDeleted': $this->instance->documentDateDeleted  = null; break;
			case 'documentAuthor': $this->instance->documentAuthor  = null; break;
			case 'documentMetadata': $this->instance->documentMetadata  = null; break;
			default: throw new \Exception("invalid argument: $name");
		}
	}
	/**
	 * @param string $name
	 * @param mixed $value
	 * @throws \Exception
	 */
	public function set_as_mixed(string $name, $value):void
	{
		switch ($name) {
			case 'documentId': $this->instance->documentId  = (int)$value; break;
			case 'documentType': $this->instance->documentType  = (int)$value; break;
			case 'documentKey': $this->instance->documentKey  = (string)$value; break;
			case 'documentTitle': $this->instance->documentTitle  = (string)$value; break;
			case 'documentContent': $this->instance->documentContent  = (string)$value; break;
			case 'documentTag': $this->instance->documentTag  = (string)$value; break;
			case 'documentVersion': $this->instance->documentVersion  = (int)$value; break;
			case 'documentDateCreated': $this->instance->documentDateCreated  = (int)$value; break;
			case 'documentDateChanged': $this->instance->documentDateChanged  = (int)$value; break;
			case 'documentDateDeleted': $this->instance->documentDateDeleted  = (int)$value; break;
			case 'documentState': $this->instance->documentState  = (int)$value; break;
			case 'documentAuthor': $this->instance->documentAuthor  = (int)$value; break;
			case 'documentMetadata': $this->instance->documentMetadata  = $value; break;
			default: throw new \Exception("invalid argument: $name");
		}
	}
	/**
	 * @param string $name
	 * @return mixed
	 * @throws \Exception
	 */
	public function get_as_mixed(string $name)
	{
		switch ($name) {
			case 'documentId': return $this->instance->documentId; break;
			case 'documentType': return $this->instance->documentType; break;
			case 'documentKey': return $this->instance->documentKey; break;
			case 'documentTitle': return $this->instance->documentTitle; break;
			case 'documentContent': return $this->instance->documentContent; break;
			case 'documentTag': return $this->instance->documentTag; break;
			case 'documentVersion': return $this->instance->documentVersion; break;
			case 'documentDateCreated': return $this->instance->documentDateCreated; break;
			case 'documentDateChanged': return $this->instance->documentDateChanged; break;
			case 'documentDateDeleted': return $this->instance->documentDateDeleted; break;
			case 'documentState': return $this->instance->documentState; break;
			case 'documentAuthor': return $this->instance->documentAuthor; break;
			case 'documentMetadata': return $this->instance->documentMetadata; break;
			default: throw new \Exception("invalid argument: $name");
		}
	}
	/**
	 * @param string $name
	 * @param \Sigmalab\SimpleReflection\IReflectedObject $value
	 * @throws \Exception
	 */
	public function set_as_object(string $name, \Sigmalab\SimpleReflection\IReflectedObject $value):void
	{
		switch ($name) {
			default: throw new \Exception("invalid argument: $name");
		}
	}

	/**
	 * @param string $name
	 * @return \Sigmalab\SimpleReflection\IReflectedObject 
	 * @throws \Exception
	 */
	public function get_as_object(string $name):?\Sigmalab\SimpleReflection\IReflectedObject 
	{
		switch ($name) {
			case 'documentMetadata': return $this->instance->documentMetadata;
			default: throw new \Exception("invalid argument: $name");
		}
	}

	/**
	 * @param string $name
	 * @param \Sigmalab\SimpleReflection\IReflectedObject[] $value
	 * @throws \Exception
	 */
	public function set_as_objects(string $name, array $value):void
	{
		switch ($name) {
			default: throw new \Exception("invalid argument: $name");
		}
	}

	/**
	 * @param string $name
	 * @return \Sigmalab\SimpleReflection\IReflectedObject[] 
	 * @throws \Exception
	 */
	public function get_as_objects(string $name):array
	{
return []; /* exception will be prefer , but bug. */
	}
}
