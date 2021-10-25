<?php

namespace Sigmalab\DatabaseEngine\Gate;
/**
 * @kphp-serializable
 * Class SqlResponse
 */
class SqlResponse
{
	/**
	 * @kphp-serialized-field 0
	 * @var mixed[]
	 */
	public array $result;
	/**
	 * @kphp-serialized-field 1
	 * @var string
	 */
	public string $error;

}