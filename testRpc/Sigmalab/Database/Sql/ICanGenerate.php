<?php

namespace Sigmalab\Database\Sql;

interface ICanGenerate
{
	function generate(SQLGenerator $generator, ?string $defaultTable = null);
}


