<?php

use Sigmalab\Database\Core\DBResultContainer;
use Sigmalab\Database\Core\IDataSource;
use Sigmalab\Database\DatabaseBusyException;
use Sigmalab\Database\DatabaseException;
use Sigmalab\Database\Sql\SQLStatement;
use Sigmalab\Database\Sql\SQLStatementDelete;
use Sigmalab\Database\Sql\SQLStatementInsert;
use Sigmalab\Database\Sql\SQLStatementSelect;
use Sigmalab\Database\Sql\SQLStatementUpdate;
use Sigmalab\Database\SQLGenerator;
use Sigmalab\Database\SQLStatementSelectResult;

if( !defined( "__ADO_DATASOURCE_PHP_DIR__" ) ) define(  "__ADO_DATASOURCE_PHP_DIR__", dirname( __FILE__ ) );
require_once(__ADO_DATASOURCE_PHP_DIR__ . "/IDataSource.php");


// error codes
define( "DS_SUCCESS", 0 );
define( "DS_ERROR", 1 );
define( "DS_CANT_CONNECT", 2 );
define( "DS_CANT_SELECT_DB", 3 );
define( "DS_METHOD_DOESNT_SUPPORTED", 4 );
define( "DS_MSG_NOLINK", "Link is not actived" );


/**
 * Base abstract  class for SQL data source implementation .
 * have support for executing statements.
 *
 */
abstract class DBDataSource extends IDataSource
{
	var $lastError = NULL;
	var $timefunc = "time";
	var $signSuppressError = false;
	var $signDebugQueries = false;
	var $signShowQueries = false; 
	
	/**
	 * Connect string, data source name (DSN)
	 *
	 * @var string
	 */
	var $connectString = "";
	
	
	/**
	 * Register connect string for using in messages.
	 * @access protected
	 * @param string $connectString  DSN (Data source name)
	 */
	function setConnectString($connectString)
	{
		$this->connectString = $connectString;
	}


	/**
	 * Execute SQL statement
	 *
	 * @param SQLStatementSelect|SQLStatementDelete|SQLStatementUpdate|SQLStatementInsert $stm
	 * @param DBResultcontainer|DBDefaultResultContainer|SQLStatementSelectResult $resultContainer  container strategy
	 * @return int zero on success
	 * @throws Exception
	 * @throws DatabaseException
	 * @throws DatabaseBusyException
	 * @see SQLStatementSelectResult
	 * @see SQLStatementSelect::createResultContainer()
	 * @see DBResultContainer
	 */
	function queryStatement($stm, $resultContainer=NULL )
	{
		$generator = $this->getGenerator();

		if  ( $stm->isDebug) {
			$this->getLogger()->debug("from {$stm->isDebug}");
			$this->getLogger()->debug($generator->generate($stm));
		}

		//$query = $generator->generate($stm);
		$this->resetError();
		
		if ( !$this->isLinkAvailable() ) {
			 $this->registerError( "", DS_MSG_NOLINK ); 
			 return DS_ERROR; 
		}

		if ( !$resultContainer) {
			$resultContainer = $stm->createResultContainer();
		}

		$resultContainer->begin();
		$rc = $this->_executeStatement($stm, $resultContainer);
		$resultContainer->end();
				
		return $rc;
	}
	
	/**
	 * Execute statement. 
	 * 
	 * This method cabe overriden in inherit class for special procesing statements.
	 *
	 * @access protected.
	 * @param SQLStatement|SQLStatementSelect|SQLStatementInsert|SQLStatementUpdate  $stm
	   @param DBResultcontainer|DBDefaultResultContainer|SQLStatementResultContainer $resultcontainer  contaner stategy
	 * @return int
	 */
	protected function _executeStatement($stm, &$resultContainer)
	{
		$generator = $this->getGenerator();
		
		$class = get_class( $stm );
		switch( $class )
		{
			case SQLStatementSelect::class:
				$rc= $this->querySelectEx( $generator->generate($stm), $resultContainer  );
				break;
			case SQLStatementInsert::class:
				$rc= $this->queryCommand($generator->generate($stm), $resultContainer  );
				//save pk value
				$pkname = $stm->object->primary_key();
				$stm->object->{$pkname} = $this->lastID();
				break;
			case SQLStatementUpdate::class:
			case SQLStatementDelete::class:
				$rc= $this->queryCommand($generator->generate($stm), $resultContainer  );
				break;
			default:
				throw new Exception("Don't know how to execute  $class");
		}
		return $rc;
	}
	
	/**
	 * set suppression errors mode.
	 *
	 * @param bool $sign
	 */
	function suppressError($sign = true) 
	{
		$this->signSuppressError = $sign;
	}
	
	/**
	 * Reset last error.
	 * @access private
	 */
	function resetError() 
	{
		$this->lastError = null;
	}
	
	/**
	 * register error caused in query execution.
	 *
	 * @access protected
	 * @param string $query   SQL query
	 * @param string $appError  error string
	 */
	function registerError( $query, $appError = null )
	{
		$logger = $this->getLogger();
		
		if ( $appError ) $this->lastError = $appError;
		else $this->lastError = $this->getEngineError();
		
		if ( $this->signDebugQueries ) {
			$logger->warning( $this->getEngineName() . " Error: {$this->lastError}" );
		}
		if ( $this->signSuppressError ) {
			if ($this->signSuppressError == SUPPRESS_ERROR_SINGLE || $this->signSuppressError === true ) {
				$this->signSuppressError = false;
			}
			return;
		}
		if ( !$appError ) {
			$logger->warning( "in query: $query <br>\n{$this->getEngineName()} Error: $this->lastError" );
		}
	}	
	
	/**
	 * Register error about method not supported.

	 * @param string $scheme  scheme(protocol)  name
	 * @return integer  data source error code
	 * @access protected
	 */
	function errorMethodNotSupported($scheme )
	{
		$this->registerError( "", "Method '{$scheme}'' does not supported" );
		return( DS_METHOD_DOESNT_SUPPORTED );
	}
	
	/**
	 * Retrieve eroror message or code from DB engine (mysql/...)
	 * @return string error message
	 * @access protected
	 */
	abstract function  getEngineError();

	/**
	 * Gets DB engine name.
	 * @return string engine name (mysql, or sqlite..)
	 * @access protected
	 */
	abstract function getEngineName();

	/**
	 * Gets links available status
	 * @return bool TRUE if Engine link is available , else FALSE 
	 * @access protected
	 * 
	 */
	abstract function isLinkAvailable();

 	/**
	 * Gets SQLGenerator according to implemented SQL engine.
	 * @return SQLGenerator
	 * @access protected
	 */
	abstract function getGenerator();

	/**
	 * Gets logger object.
	 * @return DataSourceLogger  logger instance
	 * @access protected
	 */
	abstract function getLogger();

	/** query "SELECT" to container
	 * @param string $query     SQL query
	 * @param DBResultcontainer|DBDefaultResultContainer|SQLStatementREsultContainer
         $resultcontainer  contaner stategy 
	 * @return integer zero on success
	 * @see DBResultcontainer
	 * @see DBDefaultResultContainer
	 * @access public
	 */
	abstract  function querySelect( $query, &$resultContainer );

	/** query "INSERT/UPDATE/DELETE"
	 * @param string $query SQL query
	 * @param DBResultcontainer|DBDefaultResultContainer|SQLStatementREsultContainer
         $resultcontainer   contaner stategy. method must returns count for affected rows as result set  
	 * @return integer  0 on success or error code
     * @access public
	*/
	abstract function queryCommand( $query, &$resultcontainer );


	/**
	 * Gets last intsert ID.
	 * @return integer
	 * @access public
	 */
	abstract function lastID();
}
