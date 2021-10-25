<?php

use Sigmalab\AdoDatabase\Sqlite\SqliteGenerator;
use Sigmalab\Database\Core\DBResultContainer;
use Sigmalab\Database\DatabaseBusyException;
use Sigmalab\Database\DatabaseException;
use Sigmalab\Database\Sql\SQLGenerator;
use Sigmalab\Database\Sql\SQLStatement;
use Sigmalab\Database\Sql\SQLStatementDelete;
use Sigmalab\Database\Sql\SQLStatementInsert;
use Sigmalab\Database\Sql\SQLStatementSelect;
use Sigmalab\Database\Sql\SQLStatementSelectResult;
use Sigmalab\Database\Sql\SQLStatementUpdate;

require_once( __DIR__ .  "/SqliteDictionary.php");
require_once( __DIR__  . "/SqliteGenerator.php");
require_once( __DIR__  . "/../DSN.class.php");

define( "SQLITE_LOWALPHA",  "абвгдеёжзийклмнорпстуфхцчшщъьыэюя");
define( "SQLITE_HIALPHA",   "АБВГДЕЁЖЗИЙКЛМНОРПСТУФХЦЧШЩЪЬЫЭЮЯ");

function sqlite_ru_upper($string)
{
	$string = strtr($string, SQLITE_LOWALPHA,SQLITE_HIALPHA);
	$rc = strtoupper($string );
	return $rc;
}


class PdoDataSource extends DBDataSource
{
/**
 * Link object (PDO)
 *
 * @var PDO
 */
	protected $link;

	protected $preparedStm;

	protected $transactionLevel = 0;

	function __construct() {
		$this->preparedStm= array();
		
	}
	public function __destruct() {
		if ( $this->link ) {
			if ($this->link->inTransaction()) {
				$this->link->commit();
			}
			$this->link->setAttribute(PDO::ATTR_PERSISTENT, false);
		}
		$this->link = null;
	}

		/**
	 * connect to database
	 *
	 * @param string $connectString DSN  such as: "sqlite://localhost//?database=path/to/database.db"
	 * @return integer  DS_SUCCESS or error
	 */
	function connect( $connectString )
	{
		$logger = $this->getLogger();
		$logger->debug("connecting to $connectString");
		$this->setConnectString( $connectString );

		$dsn = 	new DSN( $connectString );

		$method = $dsn->getMethod();
		if ( $method  != "sqlite" ) {
			return $this->errorMethodNotSupported($method );
		}

		$file= $dsn->getDatabase();

		// Connecting, selecting database
		try {
			$this->link = null;
			$this->preparedStm = array();
			$this->link = new PDO( "sqlite:$file", "");
//			$this->link = new PDO( "sqlite:$file", "", "", array(PDO::ATTR_PERSISTENT => true));
			$this->link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			//$this->link->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE );
			$this->link->setAttribute(PDO::ATTR_PERSISTENT , false);
			$this->link->setAttribute(PDO::ATTR_TIMEOUT, 5);
			//$this->link->query("PRAGMA journal_mode = MEMORY");
		}
		catch( PDOException $exception  )
		{
			$this->registerError( "", "Can't connect to '{$file}':{$exception->getMessage()} " );
			throw new DatabaseException($exception->getMessage() . "$file");
		}

		$rc = $this->link->sqliteCreateFunction('ru_upper', 'sqlite_ru_upper');
		if ( $rc === FALSE ) {
			$logger->warning("Can't create collation for ru_RU");
		}
		return( DS_SUCCESS );
	}

	function getEngineError ()
	{
		$info = $this->link->errorInfo();
		if ( $info[0] == '00000') return 'Success.';
		return $info[2];
	}

	function getEngineName ()
	{

		return ("PDO(sqlite)");
	}
	function isLinkAvailable()
	{
		return $this->link != null;
	}

	/**
	 * returns SQL geenrator.
	 *
	 * @return SQLGenerator
	 */
	function getGenerator()
	{
		return new SqliteGenerator();
	}

	/**
	 * Gets logger intsance
	 * @return DataSourceLogger
	 */
	function getLogger()
	{
		return  DataSourceLogger::getInstance();
	}

	/** query "SELECT" to container
	 * @param string $query SQL query
	 * @param DBResultcontainer $resultcontainer     contaner stategy
	 * @return integer zero on success
	 * @throws DatabaseException
	 * @see DBDefaultResultContainer
	 * @see DBResultcontainer
	 */
	function querySelect( $query, &$resultContainer )
	{
		$resultStm = $this->link->query( $query.";", PDO::FETCH_CLASS, "stdclass" );
		return $this->_processSelectResult($resultStm, $resultContainer, $query);
	}

	/**
	 * @param PDOStatement $resultStm
	 * @param DBResultcontainer $resultContainer
	 * @param $query
	 * @return int
	 * @throws DatabaseException
	 */
	protected function _processSelectResult(PDOStatement $resultStm, &$resultContainer, $query)
	{
		if ( !$resultStm) {
			throw new DatabaseException("PDO query error: {$this->getEngineError()}\nQuery: $query ");
		}
		$count = 0;
		foreach( $resultStm->fetchAll(PDO::FETCH_NUM) as $row ) {
			$obj = $resultContainer->fromSQL( $row );
			$resultContainer->add( $obj );
			$count++;
		}
		if ( $this->signDebugQueries) {
			$this->getLogger()->debug( "select result: $count items" );
		}

		return 0;
	}


	/**
	 * @param $query
	 * @param $resultContainer
	 * @return int
	 * @throws DatabaseException
	 */
	function querySelectEx( $query, &$resultContainer )
	{
		return $this->querySelect($query, $resultContainer);
	}

	/** query "INSERT/UPDATE/DELETE"
	 * @param string $query SQL query
	 * @param DBResultContainer|DBDefaultResultContainer|SQLStatementSelectResult $resultContainer   container strategy. method must returns count for affected rows as result set
	 * @return integer  0 on success or error code
	 * @throws DatabaseBusyException
	 */
	function queryCommand( $query, &$resultContainer )
	{
		try  {
			$rowsAffected = $this->link->exec($query.";");
		}
		catch( PDOException $e ) {
			if ($e->getCode() == "HY000" && strstr($e->getMessage(), "locked") !== false) {
				$this->getLogger()->warning("locked...");
				throw new DatabaseBusyException($e);
			}
			else {
				$this->getLogger()->error( $query );
			}
			throw $e;
		}

		$resultContainer->add( $rowsAffected );
		return 0;
	}


	/**
	 * Execute statement.
	 *
	 * This method cabe overriden in inherit class for special procesing statements.
	 *
	 * @access protected.
	 * @param SQLStatement|SQLStatementSelect|SQLStatementInsert|SQLStatementUpdate $stm
	 * @param DBResultcontainer|DBDefaultResultContainer|SQLStatementSelectResult $resultContainer contaner stategy
	 * @throws DatabaseException
	 * @throws DatabaseBusyException
	 * @throws Exception
	 */
	protected function _executeStatement($stm, &$resultContainer)
	{
	//process query
		//$rc = false;
		$generator = $this->getGenerator();

		$class = get_class( $stm );
		$rc = null;
		switch( $class )
		{
			case SQLStatementSelect::class:
				for( ;; ) {
					try {
						$pdoStm = $this->_preparePdoStatement($stm);
						$pdoStm->execute();
						$rc = $this->_processSelectResult($pdoStm, $resultContainer, "SQL query");
					} catch (\Exception $e) {
						if ($e->getCode() == 5) {
							if (strstr($e->getMessage(), "locked") !== false) {
								continue;
							}
						}

						$message = "Can't execute statement from $stm->cacheKey\n"
							. " {$stm->generate($generator)} \n==\n {$stm->querySql}\n\n"
							. "params:" . count($stm->queryParams)
							. "Error: "
							. $e->getMessage()
							. " from " . $e->getFile() . ':' . $e->getLine();
						if  (php_sapi_name() == "cli") {
							print_r($message);
						}
						throw new DatabaseException(
							$message
						);
					}
					break;
				}
				break;
			case SQLStatementDelete::class:

				$sql = $generator->generate($stm);
				try {
					$pdoStm = $this->link->prepare($sql.";");
				}
				catch( \PDOException $e)
				{
					throw new DatabaseException("Can't prepare statement: $sql\nError: " . $e->getMessage());
				}

				if (! $pdoStm) {
					throw new DatabaseException("Can't prepare statement: $sql\nError: " . $this->getEngineError());
				}

				$this->repeatWhenLocked(function()use($pdoStm, &$rowsAffected, &$resultContainer, &$rc){
					$rc = $pdoStm->execute();
					$rowsAffected = $pdoStm->rowCount();
					$resultContainer->add( $rowsAffected );
				},function(){});
				break;

			case SQLStatementUpdate::class:
			case SQLStatementInsert::class:
				$rc =null;
				$pdoStm = null;
				$this->repeatWhenLocked(
					function () use (&$pdoStm, &$rc, $stm) {
						$pdoStm = $this->_preparePdoStatement($stm);
						$rc = $pdoStm->execute();
					},
					function () use (&$pdoStm) {
						$this->getLogger()->warning('exception. ' . @$pdoStm->queryString);
						$this->resetLastPdoStm();
					});

				$rowsAffected = $pdoStm->rowCount();
				$pdoStm->closeCursor();
				$resultContainer->add($rowsAffected );
				break;
			default:
				throw new DatabaseException("Don't know how to execute  $class");
		}
		return $rc;
	}


	/**
	 * @param $pdoStm
	 * @return array
	 * @throws DatabaseException
	 */
	function doExecuteStm(SQLStatement $stm)
	{

	}

	private function resetLastPdoStm()
	{
		$this->getLogger()->warning('reset last sql:'. $this->lastSql );
		unset( $this->preparedStm[$this->lastSql] );
	}

	var $lastSql;
	function _preparePdoStatement(SQLStatement $stm)
	{
		$generator = $this->getGenerator();
		$query = $generator->generateParametrizedQuery($stm);

		//file_put_contents('/tmp/query', var_export($query, true));
		$sql   = $query->getQuery();

		if ( $this->signShowQueries ) {
			print_r( $query );
		}
		if ( $this->signDebugQueries) {
			$this->getLogger()->debug( $query );
		}
        if (!isset($this->preparedStm[$sql] )) {
			try {
				$pdoStm =  $this->link->prepare($sql .";");
			}
			catch( PDOException $e ) {
				$text =  $e->getMessage() . "\n\n sql: $sql" ;
				throw new DatabaseException( $text, 0, $e);
			}
	        $this->lastSql = $sql;
			$this->preparedStm[$sql] = $pdoStm;
		}
		else 
		{
			$this->lastSql = $sql;
			$pdoStm = $this->preparedStm[$sql];
		}
		
		if ( !$pdoStm ) {
			throw new DatabaseException("Can't prepare statement: $sql\nError: "
				. $this->getEngineError()
				. 'STM: ' . Diagnostics::dumpVar($stm));
		}
		foreach( $query->getParameters() as $param ){

			$rc = $pdoStm->bindValue( $param->name, $param->value, $this->_getPdoType( $param->type ) );

			if ( $rc === FALSE ) {
				throw new DatabaseException("Can't bind value to statement: $sql\nError: " . $this->getEngineError());
			}
		}
		return $pdoStm;
	}

	/**
	 * Get PDO type from Temis.ADO type
	 *
	 * @param string $sqlType  Temis.ADO type
	 * @access private
	 */
	protected function _getPdoType( $sqlType )
	{
		$map = array(
			DBParamType_integer => PDO::PARAM_INT,
			DBParamType_string => PDO::PARAM_STR,
			DBParamType_lob => PDO::PARAM_LOB,
			DBParamType_bool => PDO::PARAM_INT,
			DBParamType_null => PDO::PARAM_NULL,
			DBParamType_real => PDO::PARAM_STR
		);

		if ( !array_key_exists($sqlType, $map)) return PDO::PARAM_STR;
		return $map[$sqlType];
	}

	/**
	 * Gets last intsert ID.
	 * @return integer
	 * @access public
	 */
	function lastID()
	{
		assert($this->link != null);
		return intval($this->link->lastInsertId());
	}

	function inTransaction()
	{
		return $this->link->inTransaction();
	}
	
	function beginTransaction()
	{
		if ( $this->transactionLevel == 0 ) {
			$this->repeatWhenLocked(function(){
				$this->link->beginTransaction();
			}, function(){});
		}
		$this->transactionLevel++;

	}

	/**
	 * @throws Exception
	 */
	function commitTransaction()
	{
		$this->transactionLevel--;
		if ($this->transactionLevel != 0) return;

		$this->repeatWhenLocked(function () {
			$this->link->commit();
		}, function () {
		});
	}


	/** Run method and process locked database state
	 *
	 * @param Closure $method  target method
	 * @param Closure $whenLocked  method which need to call when database locked, for retry
	 * @throws Exception
	 * @throws DatabaseBusyException
	 * @throws DatabaseException
	 */
	function repeatWhenLocked(\Closure $method, \Closure $whenLocked)
	{
		for( $tries=0; $tries < 5; ++$tries) {
			try {
				$method();
			} catch (\PDOException $e) {
				$this->getLogger()->warning("PDO exception:" . $e->getMessage());
				if ($e->getCode() == "HY000" && strstr($e->getMessage(), "locked") !== false) {
					$this->getLogger()->warning("locked $tries. sleep...");
					$whenLocked();
					sleep(1);
					continue;
				}
				throw new DatabaseException($e);
			} catch (\Exception $e) {
				if ($e->getCode() == "HY000" && strstr($e->getMessage(), "locked") !== false) {
					$this->getLogger()->warning("locked $tries. sleep...");
					$whenLocked();
					sleep(1);
					continue;
				}
				throw new DatabaseBusyException($e);
			}
			return;
		}
		$this->getLogger()->warning("Database locked $tries tries. Fire timeout exception");
		throw new DatabaseBusyException("locked");
	}
}


