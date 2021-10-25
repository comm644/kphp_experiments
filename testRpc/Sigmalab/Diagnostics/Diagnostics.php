<?php


namespace Sigmalab\Diagnostics;

class Diagnostics implements IDiagnostics
{
	static IDiagnostics $instance;

	public static function instance()
	{
		if (self::$instance) {
			self::setInstance(new Diagnostics());
		}
		return self::$instance;
	}

	/**
	 * @param IDiagnostics $instance
	 */
	public static function setInstance(IDiagnostics $instance): void
	{
		self::$instance = $instance;
	}

	public static function warning(string $arg)
	{
		self::instance()->logWarning($arg);
	}

	public static function error($arg)
	{
		self::instance()->logError($arg);
	}

	public static function trace()
	{
		self::instance()->logTrace();
	}

	public function logWarning(string $arg)
	{
		// TODO: Implement logWarning() method.
	}

	public function logError(string $arg)
	{
		// TODO: Implement logError() method.
	}

	public function logTrace()
	{
		// TODO: Implement logTrace() method.
	}
}