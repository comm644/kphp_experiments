<?php

namespace Sigmalab\DatabaseEngine\Gate;

/**
 * @kphp-serializable
 * Class Query
 */
class SqlQuery
{
	/**
	 * @kphp-serialized-field 0
	 * @var string
	 */
	public string $dsn = "";

	/**
	 * @kphp-serialized-field 1
	 * @var string
	 */
	public string $query = "";

	/**
	 * @kphp-serialized-field 2
	 * @var SqlQueryParam[]
	 */
	public array $params = [];


}
