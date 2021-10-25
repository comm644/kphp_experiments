<?php

use Sigmalab\Database\SQLJoin;
use Sigmalab\Database\SQLStatementDelete;
use Sigmalab\Database\SQLStatementInsert;
use Sigmalab\Database\SQLStatementSelect;
use Sigmalab\Database\SQLStatementUpdate;

/**
 * Class ExtendedObjectsStorage provides simple storage for 1 level inheritance
 */
class ExtendedObjectsStorage
{
	/**
	 * @var DBObject
	 */
	var $proto;

	/**
	 * @var DBObject
	 */
	var $protoParent;

	/**
	 * Statement runner.
	 * @var IStatementRunner
	 */
	var $runner;

	function __construct(IStatementRunner $runner, DBObject $proto, $protoParent = NULL)
	{
		if (!$protoParent) {
			$protoParent = $proto->parentPrototype();
		}

		$this->proto = $proto;
		$this->protoParent = $protoParent;
		$this->runner= $runner;
	}

	/**
	 * @return \DBObject
	 */
	public function proto()
	{
		return $this->proto;
	}

	/**
	 * @return \DBObject
	 */
	public function protoParent()
	{
		return $this->protoParent;
	}

	/**
	 * @return \IStatementRunner
	 */
	protected function database()
	{
		return $this->runner;
	}



	/**
	 * Gets parent object for given object.
	 *
	 * @param DBObject $obj
	 * @return DBObject
	 */
	function getParentObject(DBObject $obj)
	{
		$parent = $obj->parentPrototype();
		foreach (get_object_vars($parent) as $name => $value) {
			if (!isset($obj->$name)) {
				//object was shortified
				continue;
			}
			$parent->$name = $obj->$name;
			if ($obj->isMemberChanged($name)) {
				$parent->setChanged($name);
			}
		}
		return $parent;
	}

	/**
	 * @param DBObject $obj
	 * @return DBObject
	 */
	function getSelfObject(DBObject $obj)
	{
		$class = get_class($obj);

		$object = new $class;

		foreach ( $obj->getColumnDefinition() as  $def) {
			$name = $def->getAliasOrName();
			$object->$name = $obj->$name;
			if ($obj->isMemberChanged($name)) {
				$object->setChanged($name);
			}
		}
		return $object;
	}

	function insert(DBObject $obj, DBObject $root=null)
	{
		if ( !$root ) {
			$root = $obj;
		}
		if ( $obj->getParentKey() == NULL) {
			$obj->set_primary_key_value($this->database()->execute(new SQLStatementInsert($obj)));
			return $obj->get_primary_key_value();
		}

		if ( $obj->get_parent_key_value() <= 0) {
			$parentObject = $this->getParentObject($obj);
			$obj->set_parent_key_value($this->insert($parentObject, $root));
			$root->{$obj->getParentKey()->ownerTag()->getName()} = $parentObject->get_primary_key_value();
		}

		$obj->set_primary_key_value($this->database()->execute(new SQLStatementInsert($obj)));
		return $obj->get_primary_key_value();
	}

	function update(DBObject $obj)
	{
		if ( $obj->getParentKey() == NULL) {
			if ( $obj->isChanged()) {
				if ( count($obj->_changedColumns) == 1 && array_key_exists($obj->getPrimaryKeyTag()->getName(), $obj->_changedColumns) ) {
					//changed only PK on the same
					return;
				}
				$this->database()->execute(new SQLStatementUpdate($obj));
			}
			return;
		}

		$this->update($this->getParentObject($obj));

		$self = $this->getSelfObject($obj);

		if ($self->isSelfFieldsChanged()) {
			$this->database()->execute(new SQLStatementUpdate($self));
		}

		foreach ($obj->getUpdateJoins() as $key) {
			$foreignObject = $key->foreignTag()->table;
			$foreignObject->discardChangedState(); //not required because generated

			//select stored object
			$stm = new SQLStatementSelect($foreignObject);
			$stm->addExpression(new ExprEQ($key->foreignTag(), $foreignObject->getValue($key->foreignTag()->getName())));
			$storedForeignObject = Helper::executeSelectOne($stm);

			//use reflection for copy properties
			foreach ($storedForeignObject->getColumnDefinition() as $def) {
				if  ($def->equals($storedForeignObject->getPrimaryKeyTag())) continue;
				$set = 'set_'.$def->getName();
				$get = 'get_'.$def->getName();
				$storedForeignObject->$set($foreignObject->$get());
			}
			if  ($storedForeignObject->isChanged()) {
				Helper::execute(new SQLStatementUpdate($storedForeignObject));
			}
		}

	}

	function smartUpdate(DBObject $obj)
	{
		if ( $obj->isNew()) {
			$this->insert($obj);
		}
		else {
			$this->update($obj);
		}
	}

	function delete(DBObject $obj)
	{
		$parent = $this->getParentObject($obj);

		//must be ondelete-cascade - check on generating step!!.
		$this->database()->execute(new SQLStatementDelete($parent));
	}


	/** Get default select
	 * @return SQLStatementSelect
	 */
	function stmSelect()
	{
		$stm = new SQLStatementSelect($this->proto);

		$parentKey = $this->proto->getParentKey($this->protoParent);
		if ( !$parentKey ) {
			return $stm;
		}

		$object = $this->proto;
		$parent = $object->parentPrototype();

		while( $parent != NULL) {
			$parentKey = $object->getParentKey($parent);
			$stm->addJoin( SQLJoin::createByPair($parentKey->ownerTag(), $parentKey->foreignTag()));
			$object = $parent;
			$parent = $object->parentPrototype();
		}

		$columns = array();
		$stm->resetColumns();
		foreach( $stm->object->getColumnDefinitionExtended($columns) as $def ) {
			$stm->addColumn($def);
		}

		foreach ($stm->object->getSelectJoins() as $join) {
			$stm->addJoin($join);
		}
		return $stm;
	}
	function stmSelectByDetailsId($id)
	{
		if ( !is_array($id)) {
			$id = array( $id );
		}
		$stm = $this->stmSelect();
		$stm->addExpression( new ExprIN($this->proto()->getPrimaryKeyTag(), $id) );
		return $stm;
	}
	function stmSelectByParentId($id)
	{
		if ( !is_array($id)) {
			$id = array( $id );
		}
		$stm = $this->stmSelect();
		$stm->addExpression( new ExprIN($this->protoParent()->getPrimaryKeyTag(), $id) );
		return $stm;
	}

	function stmAddJoins(SQLStatementSelect $stm )
	{
		$parentKey = $this->proto->getParentKey($this->protoParent);
		if ( !$parentKey ) {
			return $stm;
		}

		$object = $this->proto;
		$parent = $object->parentPrototype();

		while( $parent != NULL) {
			$parentKey = $object->getParentKey($parent);
			$stm->addJoin( SQLJoin::createByPair($parentKey->ownerTag(), $parentKey->foreignTag()));

			$object = $parent;
			$parent = $object->parentPrototype();
		}
	}
}