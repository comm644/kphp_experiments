<?php

namespace Sigmalab\Database\Sql;

interface IColumnName
{
	function getColumn(): ?string;

	function getTable(): ?string;
}