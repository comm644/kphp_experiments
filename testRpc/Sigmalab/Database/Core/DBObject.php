<?php
/******************************************************************************
 * Copyright (c) 2005 by Alexei V. Vasilyev.  All Rights Reserved.
 * -----------------------------------------------------------------------------
 * Module     : Database Object base class
 * File       : DBObject.php
 * Author     : Alexei V. Vasilyev
 * -----------------------------------------------------------------------------
 * Description: for describing datasets
 ******************************************************************************/

namespace Sigmalab\Database\Core;

use Sigmalab\Database\Expressions\ExprAND;
use Sigmalab\Database\Expressions\ExprEQ;
use Sigmalab\Database\Expressions\IExpression;
use Sigmalab\Database\Sql\SQLJoin;
use Sigmalab\SimpleReflection\ClassRegistry;

/** base class for DataObjects/table_definitions
 */
abstract class DBObject
	implements IDataObject
{
	/**
	 * @var mixed[]
	 */
	private array $_changedColumns = [];

	/**
	 * @var bool
	 */
	private bool $_isChanged = false;

	/**
	 * @var string|null
	 */
	private ?string $_tableAlias = null;

	/**
	 * DBObject constructor.
	 */
	public function __construct()
	{
	}


	/**
	 * Gets table name associated with object.
	 *
	 * @return string  table name
	 */
	abstract function table_name(): string;

	/** returns primary key name (obsolete/internal use only)
	 * @return string primary key column name as \b string
	 */
	abstract function primary_key():string;

	/** returns primary key value
	 * @return mixed primary key value with type as defined in database
	 */
	function primary_key_value()
	{

		return ("");
	}

	/**
	 * returns primary key tag
	 * @return DBColumnDefinition
	 */
	function getPrimaryKeyTag()
	{
		$pkname = $this->primary_key();
		$tagmethod = "tag_" . $pkname;
		$object = $this->getReflection()->invoke_as_object($tagmethod, []);
		return instance_cast($object, DBColumnDefinition::class);
	}

	/**
	 * return condition for searching by primary keys if used sevaral PKs
	 *
	 * @return IExpression for searching by primary keys
	 */
	function get_condition()
	{

		$pk = $this->primary_key();
		if (!is_array($pk)) $pk = array($pk);

		$cond = array();

		$ref = $this->getReflection();
		foreach ($pk as $key) {

			$cond[] = new ExprEQ($key, $ref->get_as_mixed($key));
		}
		$cond = new ExprAND($cond);

		return ($cond);
	}

	/** return unique ID  as text combined from several primary keys
	 * @return string  created unique ID as \b string
	 */
	function get_uid(): string
	{

		$pk = $this->primary_key();
		if (!is_array($pk)) $pk = array($pk);

		$ids[] = array();
		$ref = $this->getReflection();
		foreach ($pk as $key) {
			$pkval = $ref->get_as_mixed($key);
			if (is_numeric($pkval)) $pkval = dechex($pkval);
			else if (is_string($pkval)) $pkval = md5($pkval);
			$ids[] = $pkval;
		}
		return (implode("-", $ids));
	}

	/** returns  \a true if object was changed.
	 * @return bool value , \a true if object was changed or \a false
	 */
	function isChanged(): bool
	{
		if (!isset($this->_isChanged)) return (false);
		return ($this->_isChanged);
	}

	/**
	 * returns true if object newly created and not stored in database
	 *
	 * @return bool true if newly created
	 */
	function isNew()
	{

		$val = $this->primary_key_value();
		return ($val === 0 || $val === -1);
	}

	/** return ASSOC array with new values
	 * @return array associative \b array  of changed columns
	 */
	function getUpdatedFields()
	{
		if (!isset($this->_changedColumns)) {
			return array();
		}

		$updated = array();
		foreach ($this->_changedColumns as $name => $dummy) {
			$updated[$name] = $dummy;
		}
		return ($updated);
	}

	/** Indicates that any self field has changed.
	 * @return bool
	 */
	function isSelfFieldsChanged()
	{
		if (!isset($this->_changedColumns)) {
			return false;
		}
		foreach ($this->getColumnDefinition() as $def) {
			if (array_key_exists($def->getName(), $this->_changedColumns)) return true;
		}
		return false;

	}

	/** return Column Definition array
	 * @return DBColumnDefinition[] items - object relation scheme
	 */
	function getColumnDefinition(): array
	{
		$ref = ClassRegistry::createReflection(get_class($this), $this);
		$columnDefinition = array();
		foreach (instance_to_array($this) as $name => $value) {
			$sName = (string)$name;
			$columnDefinition[$sName] = new DBColumnDefinition($sName, gettype($ref->get_as_mixed($sName)));
		}
		return ($columnDefinition);
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

	/** set property value with state control
	 * @param string $name member name
	 * @param mixed $value new member value
	 * @return bool \a true  if new value is equals, or \a false  if member was changed
	 * */
	function setValue(string $name, $value)
	{
		$ref = $this->getReflection();
		if ($ref->get_as_mixed($name) === $value) return (true);
		$this->setChanged($name);
		$ref->set_as_mixed($name,  $value);
		return (false);
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

	/** get previous value of changed member
	 * @param string $name \b string member name
	 */
	function getPreviousValue(string $name)
	{

		if (!$this->isMemberChanged($name)) return $this->getReflection()->get_as_mixed($name);
		return ($this->_changedColumns[$name]);
	}

	/** revert changed for selected member
	 * set to member previous value , as was before any changes
	 * @param string $name \b string  member name
	 */
	function revertMemberChanges(string $name)
	{
		$ref = ClassRegistry::createReflection(get_class($this), $this);
		if (!$this->isMemberChanged($name)) return (true);

		$ref->set_as_mixed($this->getPreviousValue($name));

		unset($this->_changedColumns[$name]);
		if (count($this->_changedColumns) == 0) {
			$this->_isChanged = false;
		}

		return false;
	}

	/** get value for selected member
	 * @param string $name member name
	 * @return  mixed  member value
	 */
	function getValue(string $name)
	{
		return $this->getReflection()->get_as_mixed($name);
	}

	/** Force set state as changed because all changes
	 * can be blocked if new value identical to current
	 * @param string $name member name
	 */
	function setChanged(string $name)
	{

		$this->_isChanged = true;
		$this->_changedColumns[$name] = $this->getReflection()->get_as_mixed($name);
	}

	/** discard changed state
	 *
	 * can be used for hiding from database engine any changes.
	 */
	function discardChangedState()
	{

		if (!$this->isChanged()) return;
#ifndef KPHP
		unset($this->_isChanged);
		unset($this->_changedColumns);
#endif
	}

	/** return table alias
	 * @return string  table alias described for object table (ORM bindings)
	 */
	function getTableAlias(): string
	{

		if (!isset($this->_tableAlias)) return (null);
		return $this->_tableAlias;
	}

	/** set table alias
	 * @param string $alias table alias for current object instance (ORM bindings)
	 */
	function setTableAlias(?string $alias)
	{

		$this->_tableAlias = $alias;
		return $this;
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

	/** Gets prototype map for object
	 *
	 * array: table name => DBObject
	 *
	 * @return self[]
	 */
	function prototypeMap()
	{
		return array();
	}

	/**
	 * Sets parent object UID
	 * @param mixed $value
	 */
	function set_parent_key_value( $value)
	{
	}

	/**
	 * Gets parent object UID
	 * @return mixed
	 */
	function get_parent_key_value()
	{
		return 0;
	}

	/**
	 * Sets primary key value.
	 *
	 * @param mixed $value
	 */
	function set_primary_key_value($value)
	{
		;
		$name = $this->primary_key();
		$this->getReflection()->set_as_mixed($name, $value);
	}

	/**
	 * Gets primary key value.
	 *
	 * @return mixed
	 */
	function get_primary_key_value()
	{
		$name = $this->primary_key();
		return $this->getReflection()->get_as_mixed($name);
	}

	/**
	 * Gets parent class foreign key.
	 * @param IDataObject|null $proto
	 * @return \Sigmalab\Database\Core\DBForeignKey
	 */
	function getParentKey(?\Sigmalab\Database\Core\IDataObject $proto = null)
	{
		return NULL;
	}

	//reflection. routines for changing object properties via inheritance


	/** reset all object fields for inheritance routines and simplyfiyng object
	 */
	function reflection_resetFields()
	{
#ifndef KPHP
		//remove orig fields
		foreach ($this as $key => $var) {
			if (method_exists($this, 'tag_' . $key)) {
				unset($this->$key);
			}
		}
#endif
	}

	/** Add field to object
	 * @param \Sigmalab\Database\Core\DBColumnDefinition $tag
	 */
	function reflection_addField(DBColumnDefinition $tag)
	{
		$name = $tag->getAliasOrName();
#ifndef KPHP
		if ($tag->getType() == "string") {
			$this->{$name} = "";
		} else {
			$this->{$name} = 0;
		}
#endif
	}

	/**
	 * Compose object fields according to Database definition.
	 * should be executed from constructor.
	 */
	function reflection_compose()
	{
		$this->reflection_resetFields();
		foreach ($this->getColumnDefinition() as $def) {
			$this->reflection_addField($def);
		}
	}

	/**
	 * @return SQLJoin[]
	 */
	function getSelectJoins(): array
	{
		return [];
	}

	/**
	 * @return DBForeignKey[]
	 */
	function getUpdateJoins(): array
	{
		return [];
	}

	/**
	 * @return \Sigmalab\SimpleReflection\ICanReflection
	 */
	private function getReflection(): \Sigmalab\SimpleReflection\ICanReflection
	{
		return $ref = ClassRegistry::createReflection(get_class($this), $this);
	}
}
