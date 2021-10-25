<?php

namespace Sigmalab\DatabaseEngine\GateServer\Sqlite;

use PDO;
use Sigmalab;
use Sigmalab\Database\Core\DBParamType;
use Sigmalab\Database\DatabaseException;
use Sigmalab\Database\Sql\SQLStatementSelect;
use Sigmalab\Database\Sql\SQLStatementSelectResult;
use Sigmalab\DatabaseEngine\Gate\SqlQuery;
use Sigmalab\DatabaseEngine\Gate\SqlQueryParam;
use Sigmalab\DatabaseEngine\Gate\SqlResponse;


class GateServerSqlite implements Sigmalab\DatabaseEngine\GateServer\IGateServer
{
	const SQLITE_LOWALPHA = "абвгдеёжзийклмнорпстуфхцчшщъьыэюя";
	const SQLITE_HIALPHA = "АБВГДЕЁЖЗИЙКЛМНОРПСТУФХЦЧШЩЪЬЫЭЮЯ";

	/**
	 * Get PDO type from Temis.ADO type
	 *
	 * @param string $sqlType Temis.ADO type
	 * @access private
	 */
	protected function _getPdoType($sqlType)
	{
		$map = array(
			DBParamType::Integer => PDO::PARAM_INT,
			DBParamType::String => PDO::PARAM_STR,
			DBParamType::Lob => PDO::PARAM_LOB,
			DBParamType::Bool => PDO::PARAM_INT,
			DBParamType::Null => PDO::PARAM_NULL,
			DBParamType::Real => PDO::PARAM_STR
		);

		if (!array_key_exists($sqlType, $map)) return PDO::PARAM_STR;
		return $map[$sqlType];
	}

	function rpc_server()
	{
		$request = \rpc_server_fetch_request();

		$rpcResponse = $this->handleRequest($request);

		rpc_server_store_response($rpcResponse);
	}

	function dgram_server($port)
	{
	}

	function processRequest()
	{
		$request = file_get_contents("php://input");

		echo $this->handleRequest($request);
	}

	/**
	 * @param SqlQuery $query
	 * @return SqlResponse
	 */
	public function executeQuery(SqlQuery $query): SqlResponse
	{
		$link = new PDO($query->dsn, "");
		//$this->link = new PDO( "sqlite:$file", "", "", array(PDO::ATTR_PERSISTENT => true));
		$link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		//$this->link->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE );
		$link->setAttribute(PDO::ATTR_PERSISTENT, true);
		$link->setAttribute(PDO::ATTR_TIMEOUT, 5);
		//$this->link->query("PRAGMA journal_mode = MEMORY");

		$link->sqliteCreateFunction('ru_upper', function ($string) {
			$string = strtr($string, self::SQLITE_LOWALPHA, self::SQLITE_HIALPHA);
			$rc = strtoupper($string);
			return $rc;
		});

		try {
			$pdoStm = $link->prepare($query->query . ";");
			foreach ($query->params as $param) {
				$pdoStm->bindValue($param->name, $param->value, $this->_getPdoType($param->type));
			}

			$pdoStm->execute();
		} catch (\PDOException $e) {
			$response = new SqlResponse();
			$response->result = [];
			$response->error = $e->getMessage();
			return $response;
		}


		$result = $pdoStm->fetchAll(PDO::FETCH_NUM);

		$response = new SqlResponse();
		$response->result = $result;
		$response->error = "";
		return $response;
	}


	/**
	 * @param string $rpcRequest
	 * @return string|null
	 */
	public function handleRequest($rpcRequest)
	{
		/** @var SqlQuery $query */
		$query = instance_deserialize($rpcRequest, SqlQuery::class);
		$response = $this->executeQuery($query);
		$rpcResponse = instance_serialize($response);
		return $rpcResponse;
	}


	/**  Execute statement directly
	 *
	 * @param SQLStatementSelect $stm
	 * @param SQLStatementSelectResult $container
	 * @throws DatabaseException
	 */
	public function executeSelect(SQLStatementSelect $stm, SQLStatementSelectResult $container)
	{
		$query = $stm->generateQuery(new Sigmalab\AdoDatabase\Sqlite\SqliteGenerator());

		$sqlQuery = new SqlQuery();
		$sqlQuery->query = $query->getQuery();
		$sqlQuery->params = [];
		foreach ($query->getParameters() as $parameter) {
			$sqlQuery->params[] = SqlQueryParam::mkParam($parameter);
		}

		$sqlResponse = $this->executeQuery($sqlQuery);
		if ($sqlResponse->error) {
			throw new DatabaseException("Database error:\n " . $sqlResponse->error . "\nIn{$sqlQuery->query}\n");
		}

		$container->parseResult($sqlResponse->result);
	}
}