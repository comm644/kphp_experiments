<?php

namespace Sigmalab\DatabaseEngine\Gate;

use Sigmalab\AdoDatabase\TransportClient\ITransport;
use Sigmalab\Database\DatabaseException;
use Sigmalab\Database\Sql\SQLGenerator;
use Sigmalab\Database\Sql\SQLStatementSelectResult;

class GateDataSource
{
	private SQLGenerator $generator;
	/**
	 * @var string
	 */
	private string $dsn;
	/**
	 * @var ITransport
	 */
	private ITransport $transport;

	/**
	 * GateDataSource constructor.
	 * @param string $dsn
	 * @param SQLGenerator $generator
	 * @param ITransport $transport
	 */
	public function __construct(string $dsn, SQLGenerator $generator, ITransport $transport)
	{
		$this->generator = $generator;
		$this->transport = $transport;
		$this->dsn = $dsn;
	}

	/**
	 * @param \Sigmalab\Database\Sql\SQLStatementSelect $stm
	 * @param SQLStatementSelectResult $container
	 * @throws DatabaseException
	 */
	public function executeSelect(\Sigmalab\Database\Sql\SQLStatementSelect $stm, SQLStatementSelectResult $container )
	{
		$query = $stm->generateQuery($this->generator);

		$sqlQuery = new SqlQuery();
		$sqlQuery->dsn = $this->dsn;
		$sqlQuery->query = $query->getQuery();
		foreach ( $query->getParameters() as $parameter ){
			$sqlQuery->params[] = SqlQueryParam::mkParam($parameter);
		};

		$package = instance_serialize($sqlQuery);

		$result = $this->transport->call((string)$package);

		/** @var SqlResponse $response */
		$response = instance_deserialize($result, SqlResponse::class);
		if  (!$response) {
			throw new DatabaseException("Deserialize error in:".$result."\n");
		}
		if ($response->error) {
			throw new DatabaseException("Database error:\n ".$response->error."\nIn{$sqlQuery->query}\n");
		}

		$container->parseResult($response->result);
	}
}