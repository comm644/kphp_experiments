<?php

namespace Sigmalab\Diagnostics;

interface IDiagnostics
{
	public function logWarning(string $arg);

	public function logError(string $arg);

	public function logTrace();
}