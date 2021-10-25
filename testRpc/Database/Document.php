<?php


namespace Database;



  use Sigmalab\Database\Core\DBColumnDefinition;
  use Sigmalab\Database\Core\IDataObject;

  /** \ingroup table_objects
 *
 * Class describes object-table mapping information for table t_document
 * @kphp-serializable
 */
class Document
	//extends \Sigmalab\Ado\Database\DBObject
	implements IDataObject
{
	//use DBObjectProps;

	/** 
	 * @access private
	 * @var int|null
	 * @kphp-serialized-field 1
	 */
	public ?int $documentId;

	/** Document type.
	 * @access private
	 * @var int
	 * @kphp-serialized-field 2
	 */
	public int $documentType;

	/** Document key. internal or foreign key. require for sync services. SRxxxx, PRREQ-NUM
	 * @access private
	 * @var string
	 * @kphp-serialized-field 3
	 */
	public string $documentKey;

	/** Document title
	 * @access private
	 * @var string|null
	 * @kphp-serialized-field 4
	 */
	public ?string $documentTitle;

	/** Document content
	 * @access private
	 * @var string|null
	 * @kphp-serialized-field 5
	 */
	public ?string $documentContent;

	/** Document tags
	 * @access private
	 * @var string|null
	 * @kphp-serialized-field 6
	 */
	public ?string $documentTag;

	/** Document version
	 * @access private
	 * @var int
	 * @kphp-serialized-field 7
	 */
	public int $documentVersion;

	/** 
	 * @access private
	 * @var int|null
	 * @kphp-serialized-field 8
	 */
	public ?int $documentDateCreated;

	/** 
	 * @access private
	 * @var int|null
	 * @kphp-serialized-field 9
	 */
	public ?int $documentDateChanged;

	/** 
	 * @access private
	 * @var int|null
	 * @kphp-serialized-field 10
	 */
	public ?int $documentDateDeleted;

	/** 
	 * @access private
	 * @var int
	 * @kphp-serialized-field 11
	 */
	public int $documentState;

	/** 
	 * @access private
	 * @var int|null
	 * @kphp-serialized-field 12
	 */
	public ?int $documentAuthor;

	/** Some metadata in json
	 * @access private
	 * @var mixed
	 * @kphp-serialized-field 13
	 */
	public $documentMetadata;

	/** construct object
	*/
	function __construct(?string $alias=null)
	{
		//parent::__construct();
		if ($alias) $this->setTableAlias($alias);
		
	  	$this->documentId =  0 ;
	  	$this->documentType =  0 ;
	  	$this->documentKey =  '' ;
	  	$this->documentTitle =  NULL ;
	  	$this->documentContent =  NULL ;
	  	$this->documentTag =  NULL ;
	  	$this->documentVersion =  0 ;
	  	$this->documentDateCreated =  NULL ;
	  	$this->documentDateChanged =  NULL ;
	  	$this->documentDateDeleted =  NULL ;
	  	$this->documentState =  0 ;
	  	$this->documentAuthor =  NULL ;
	  	$this->documentMetadata =  '{}';
	}

	/** construct object
	 * @param string|null $alias
	 * @return Document
	 */
	function getDocumentPrototype(?string $alias=null) : Document
	{
		return new Document($alias);
	}

	/** get primary key name (obsolete/internal use only)
	* @return string primary key column name , for this object it will be \a documentId
	*/
	function primary_key() : string
	{
		return( "documentId" );
	}

	/** get primary key value
	* @returns mixed primary key value with type as defined in database (value of \a documentId )
	*/
	function primary_key_value()
	{
		return( $this->documentId );
		
	}

	/** always contains \a "t_document"
	 */
	function table_name() :string
	{
		return( "t_document" );
	}

	/** always contains \a "t_document"
	*/
	function table_description():string
	{
		return( "presents many-to-many link" );
	}
	/** return \DBColumnDefinition \b array
	 * @return \Sigmalab\Database\Core\DBColumnDefinition[] items - object relation scheme
	 */
	function getColumnDefinition() : array
	{
		$columnDefinition = array();
        		$columnDefinition[ "documentId" ] = $this->tag_documentId();
		$columnDefinition[ "documentType" ] = $this->tag_documentType();
		$columnDefinition[ "documentKey" ] = $this->tag_documentKey();
		$columnDefinition[ "documentTitle" ] = $this->tag_documentTitle();
		$columnDefinition[ "documentContent" ] = $this->tag_documentContent();
		$columnDefinition[ "documentTag" ] = $this->tag_documentTag();
		$columnDefinition[ "documentVersion" ] = $this->tag_documentVersion();
		$columnDefinition[ "documentDateCreated" ] = $this->tag_documentDateCreated();
		$columnDefinition[ "documentDateChanged" ] = $this->tag_documentDateChanged();
		$columnDefinition[ "documentDateDeleted" ] = $this->tag_documentDateDeleted();
		$columnDefinition[ "documentState" ] = $this->tag_documentState();
		$columnDefinition[ "documentAuthor" ] = $this->tag_documentAuthor();
		$columnDefinition[ "documentMetadata" ] = $this->tag_documentMetadata();

		return( $columnDefinition );
	}

	/** get column definitions for foreign keys
	 *@return \Sigmalab\Database\Core\DBColumnDefinition[]
	 */
	function getForeignKeys() : array
	{
		$keyDefs = array();
		$keyDefs[ "documentAuthor" ] = $this->key_documentAuthor();
  
		return( $keyDefs );
	}

	/** returns \b true if object is newly created
	* @return bool
	*/
	function isNew() : bool
	{
		$val = $this->primary_key_value() ;
		return( $val === 0 || $val === -1 );
	}

	// Set/Get methods

    
	/** set value to documentId  column
	* @param int|null $value  value
	* @return bool true when value changed
	*/
	function set_documentId(?int $value ) : bool
	{
		return( $this->setValue( "documentId", $value ));
	}

	/** get value from \a documentId  column
	* @return int|null value
	*/
	function get_documentId()  :?int
	{
		return( $this->documentId );
	}
	
	/** set value to documentType  column
	* @param int $value  value
	* @return bool true when value changed
	*/
	function set_documentType(int $value ) : bool
	{
		return( $this->setValue( "documentType", $value ));
	}

	/** get value from \a documentType  column
	* @return int value
	*/
	function get_documentType()  :int
	{
		return( $this->documentType );
	}
	
	/** set value to documentKey  column
	* @param string $value  value
	* @return bool true when value changed
	*/
	function set_documentKey(string $value ) : bool
	{
		return( $this->setValue( "documentKey", $value ));
	}

	/** get value from \a documentKey  column
	* @return string value
	*/
	function get_documentKey()  :string
	{
		return( $this->documentKey );
	}
	
	/** set value to documentTitle  column
	* @param string|null $value  value
	* @return bool true when value changed
	*/
	function set_documentTitle(?string $value ) : bool
	{
		return( $this->setValue( "documentTitle", $value ));
	}

	/** get value from \a documentTitle  column
	* @return string|null value
	*/
	function get_documentTitle()  :?string
	{
		return( $this->documentTitle );
	}
	
	/** set value to documentContent  column
	* @param string|null $value  value
	* @return bool true when value changed
	*/
	function set_documentContent(?string $value ) : bool
	{
		return( $this->setValue( "documentContent", $value ));
	}

	/** get value from \a documentContent  column
	* @return string|null value
	*/
	function get_documentContent()  :?string
	{
		return( $this->documentContent );
	}
	
	/** set value to documentTag  column
	* @param string|null $value  value
	* @return bool true when value changed
	*/
	function set_documentTag(?string $value ) : bool
	{
		return( $this->setValue( "documentTag", $value ));
	}

	/** get value from \a documentTag  column
	* @return string|null value
	*/
	function get_documentTag()  :?string
	{
		return( $this->documentTag );
	}
	
	/** set value to documentVersion  column
	* @param int $value  value
	* @return bool true when value changed
	*/
	function set_documentVersion(int $value ) : bool
	{
		return( $this->setValue( "documentVersion", $value ));
	}

	/** get value from \a documentVersion  column
	* @return int value
	*/
	function get_documentVersion()  :int
	{
		return( $this->documentVersion );
	}
	
	/** set value to documentDateCreated  column
	* @param int|null $value  value
	* @return bool true when value changed
	*/
	function set_documentDateCreated(?int $value ) : bool
	{
		return( $this->setValue( "documentDateCreated", $value ));
	}

	/** get value from \a documentDateCreated  column
	* @return int|null value
	*/
	function get_documentDateCreated()  :?int
	{
		return( $this->documentDateCreated );
	}
	
	/** set value to documentDateChanged  column
	* @param int|null $value  value
	* @return bool true when value changed
	*/
	function set_documentDateChanged(?int $value ) : bool
	{
		return( $this->setValue( "documentDateChanged", $value ));
	}

	/** get value from \a documentDateChanged  column
	* @return int|null value
	*/
	function get_documentDateChanged()  :?int
	{
		return( $this->documentDateChanged );
	}
	
	/** set value to documentDateDeleted  column
	* @param int|null $value  value
	* @return bool true when value changed
	*/
	function set_documentDateDeleted(?int $value ) : bool
	{
		return( $this->setValue( "documentDateDeleted", $value ));
	}

	/** get value from \a documentDateDeleted  column
	* @return int|null value
	*/
	function get_documentDateDeleted()  :?int
	{
		return( $this->documentDateDeleted );
	}
	
	/** set value to documentState  column
	* @param int $value  value
	* @return bool true when value changed
	*/
	function set_documentState(int $value ) : bool
	{
		return( $this->setValue( "documentState", $value ));
	}

	/** get value from \a documentState  column
	* @return int value
	*/
	function get_documentState()  :int
	{
		return( $this->documentState );
	}
	
	/** set value to documentAuthor  column
	* @param int|null $value  value
	* @return bool true when value changed
	*/
	function set_documentAuthor(?int $value ) : bool
	{
		return( $this->setValue( "documentAuthor", $value ));
	}

	/** get value from \a documentAuthor  column
	* @return int|null value
	*/
	function get_documentAuthor()  :?int
	{
		return( $this->documentAuthor );
	}
	
	/** set value to documentMetadata  column
	* @param mixed $value  value
	* @return bool true when value changed
	*/
	function set_documentMetadata( $value ) : bool
	{
		return( $this->setValue( "documentMetadata", $value ));
	}

	/** get value from \a documentMetadata  column
	* @return mixed value
	*/
	function get_documentMetadata() 
	{
		return( $this->documentMetadata );
	}
	


	//Tags
    
	/** get column definition for \a documentId column
	 * @param ?string $alias  alias for \a documentId column which will be used for on SQL query generation stage
	 * @return \Sigmalab\Database\Core\DBColumnDefinition
	 */
	function tag_documentId(?string $alias=null )
	{
	    $def = new \Sigmalab\Database\Core\DBColumnDefinition( "documentId", "int",$alias,$this, false, "", false);

		return( $def );
	}
	
	/** get column definition for \a documentType column
	 * @param ?string $alias  alias for \a documentType column which will be used for on SQL query generation stage
	 * @return \Sigmalab\Database\Core\DBColumnDefinition
	 */
	function tag_documentType(?string $alias=null )
	{
	    $def = new \Sigmalab\Database\Core\DBColumnDefinition( "documentType", "int",$alias,$this, false, "Document type.", false);

		return( $def );
	}
	
	/** get column definition for \a documentKey column
	 * @param ?string $alias  alias for \a documentKey column which will be used for on SQL query generation stage
	 * @return \Sigmalab\Database\Core\DBColumnDefinition
	 */
	function tag_documentKey(?string $alias=null )
	{
	    $def = new \Sigmalab\Database\Core\DBColumnDefinition( "documentKey", "string",$alias,$this, false, "Document key. internal or foreign key. require for sync services. SRxxxx, PRREQ-NUM", false);

		return( $def );
	}
	
	/** get column definition for \a documentTitle column
	 * @param ?string $alias  alias for \a documentTitle column which will be used for on SQL query generation stage
	 * @return \Sigmalab\Database\Core\DBColumnDefinition
	 */
	function tag_documentTitle(?string $alias=null )
	{
	    $def = new \Sigmalab\Database\Core\DBColumnDefinition( "documentTitle", "string",$alias,$this, false, "Document title", true);

		return( $def );
	}
	
	/** get column definition for \a documentContent column
	 * @param ?string $alias  alias for \a documentContent column which will be used for on SQL query generation stage
	 * @return \Sigmalab\Database\Core\DBColumnDefinition
	 */
	function tag_documentContent(?string $alias=null )
	{
	    $def = new \Sigmalab\Database\Core\DBColumnDefinition( "documentContent", "string",$alias,$this, false, "Document content", true);

		return( $def );
	}
	
	/** get column definition for \a documentTag column
	 * @param ?string $alias  alias for \a documentTag column which will be used for on SQL query generation stage
	 * @return \Sigmalab\Database\Core\DBColumnDefinition
	 */
	function tag_documentTag(?string $alias=null )
	{
	    $def = new \Sigmalab\Database\Core\DBColumnDefinition( "documentTag", "string",$alias,$this, false, "Document tags", true);

		return( $def );
	}
	
	/** get column definition for \a documentVersion column
	 * @param ?string $alias  alias for \a documentVersion column which will be used for on SQL query generation stage
	 * @return \Sigmalab\Database\Core\DBColumnDefinition
	 */
	function tag_documentVersion(?string $alias=null )
	{
	    $def = new \Sigmalab\Database\Core\DBColumnDefinition( "documentVersion", "int",$alias,$this, false, "Document version", false);

		return( $def );
	}
	
	/** get column definition for \a documentDateCreated column
	 * @param ?string $alias  alias for \a documentDateCreated column which will be used for on SQL query generation stage
	 * @return \Sigmalab\Database\Core\DBColumnDefinition
	 */
	function tag_documentDateCreated(?string $alias=null )
	{
	    $def = new \Sigmalab\Database\Core\DBColumnDefinition( "documentDateCreated", "int",$alias,$this, false, "", true);

		return( $def );
	}
	
	/** get column definition for \a documentDateChanged column
	 * @param ?string $alias  alias for \a documentDateChanged column which will be used for on SQL query generation stage
	 * @return \Sigmalab\Database\Core\DBColumnDefinition
	 */
	function tag_documentDateChanged(?string $alias=null )
	{
	    $def = new \Sigmalab\Database\Core\DBColumnDefinition( "documentDateChanged", "int",$alias,$this, false, "", true);

		return( $def );
	}
	
	/** get column definition for \a documentDateDeleted column
	 * @param ?string $alias  alias for \a documentDateDeleted column which will be used for on SQL query generation stage
	 * @return \Sigmalab\Database\Core\DBColumnDefinition
	 */
	function tag_documentDateDeleted(?string $alias=null )
	{
	    $def = new \Sigmalab\Database\Core\DBColumnDefinition( "documentDateDeleted", "int",$alias,$this, false, "", true);

		return( $def );
	}
	
	/** get column definition for \a documentState column
	 * @param ?string $alias  alias for \a documentState column which will be used for on SQL query generation stage
	 * @return \Sigmalab\Database\Core\DBColumnDefinition
	 */
	function tag_documentState(?string $alias=null )
	{
	    $def = new \Sigmalab\Database\Core\DBColumnDefinition( "documentState", "int",$alias,$this, false, "", false);

		return( $def );
	}
	
	/** get column definition for \a documentAuthor column
	 * @param ?string $alias  alias for \a documentAuthor column which will be used for on SQL query generation stage
	 * @return \Sigmalab\Database\Core\DBColumnDefinition
	 */
	function tag_documentAuthor(?string $alias=null )
	{
	    $def = new \Sigmalab\Database\Core\DBColumnDefinition( "documentAuthor", "int",$alias,$this, false, "", true);

		return( $def );
	}
	
	/** get column definition for \a documentMetadata column
	 * @param ?string $alias  alias for \a documentMetadata column which will be used for on SQL query generation stage
	 * @return \Sigmalab\Database\Core\DBColumnDefinition
	 */
	function tag_documentMetadata(?string $alias=null )
	{
	    $def = new \Sigmalab\Database\Core\DBColumnDefinition( "documentMetadata", "string",$alias,$this, false, "Some metadata in json", false);

		return( $def );
	}
	
	/** Gets prototype map for an object.
	*
	* array: table name => \DBObject
	*
	* @return \Sigmalab\Database\Core\IDataObject[]
	*/
	function prototypeMap() : array
	{
		return array_merge( array('Document' => new Document()) );
	}

	//Foreign keys


	/** Foreign key for tag_documentAuthor() as link to Document::tag_documentId()
	 * @param \Sigmalab\Database\Core\IDataObject|null $proto foreign object prototype
	 * @return ?\Sigmalab\Ado\Database\DBForeignKey
	 */
	function key_documentAuthor(?\Sigmalab\Database\Core\IDataObject $proto=null)
	{
		if ($proto instanceof Document) {
			if (is_null($proto)) $proto = new Document();
			$def = new \Sigmalab\Database\Core\DBForeignKey($this->tag_documentAuthor(), $proto->tag_documentId());
			return ($def);
		}
		return null;
	}
      


	// Loaders

	/** @var bool
	 * @kphp-serialized-field none
	 */
	private bool $_isChanged = false;
	/** @var mixed[]
	 * @kphp-serialized-field none
	 */
	private array $_changedColumns = [];
	/** @var string|null
	 * @kphp-serialized-field none
	 */
	private ?string $_tableAlias = null;

	/**
	 * @inheritDoc
	 */
	function getTableAlias(): string
	{
		return $this->table_name();
	}
	/** set table alias
	 * @param ?string $alias table alias for current object instance (ORM bindings)
	 */
	function setTableAlias(?string $alias)
	{

		$this->_tableAlias = $alias;
		return $this;
	}


	/**
	 * @param string $name
	 * @param mixed $value
	 * @return bool
	 */
	function setValue(string $name, $value)
	{
		$ref = $this->getReflection();
		$previousValue = $ref->get_as_mixed($name);

		if ($previousValue === $value) return (true);
		$ref->set_as_mixed($name,  $value);

		$this->_isChanged = true;
		$this->_changedColumns[$name] = $previousValue;
		return (false);
	}

	/**
	 * Gets parent object prototype if base class (table) defined.
	 *
	 * @return \Sigmalab\Database\Core\IDataObject|null
	 */
	function parentPrototype()
	{
		return NULL;
	}

	/**
	 * @return \Sigmalab\SimpleReflection\ICanReflection
	 */
	private function getReflection(): \Sigmalab\SimpleReflection\ICanReflection
	{
		return $ref = new Document_reflection($this);
	}
	/** Get column definition for extended object
	 *
	 * @param DBColumnDefinition[] $columns
	 * @return DBColumnDefinition[]
	 */
	function getColumnDefinitionExtended(array &$columns): array
	{
		$columns = array_merge($columns, $this->getColumnDefinition());

		$parent = $this->parentPrototype();
		if ($parent) {
			$parent->getColumnDefinitionExtended($columns);
		}
		return $columns;
	}

	/** shows  changed state for selected member
	 * @param string $name member name
	 * @return bool  true when member value was changed
	 */
	function isMemberChanged(string $name) : bool
	{

		if (!$this->isChanged() || !isset($this->_changedColumns)) return (false);
		return (array_key_exists($name, $this->_changedColumns));
	}
	/** returns  \a true if object was changed.
	 * @return bool value , \a true if object was changed or \a false
	 */
	function isChanged(): bool
	{
		if (!isset($this->_isChanged)) return (false);
		return ($this->_isChanged);
	}

}

  

