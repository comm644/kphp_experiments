<?php


namespace Sigmalab\SimpleReflection;
class ClassRegistry
{

	/** @var (callable():IReflectedObject)[] */
	private static array $createClassHandlers = [];

	/** @var (callable(object):ICanReflection)[] */
	private static array $createReflectionHandlers = [];

	/**
	 * @param string $name
	 * @param callable():IReflectedObject $handler
	 */
	public static function registerClass(string $name, callable $handler)
	{
		self::$createClassHandlers[$name] = $handler;
	}

	/**
	 * @param string $name
	 * @param callable(object):ICanReflection $handler
	 */
	public static function registerReflection(string $name, callable $handler)
	{
		self::$createReflectionHandlers[$name] = $handler;
	}

	/**
	 * @param string $name
	 * @return IReflectedObject
	 */
	public static function createClass(string $name)
	{

		/** @var callable():IReflectedObject $handler */
		$handler = self::$createClassHandlers[$name];
		return $handler();
	}

	/**
	 * @param string $className
	 * @return ICanReflection
	 */
	public static function createReflection(string $className, object $instance)
	{
		/** @var callable(object):ICanReflection $handler */
		$handler = self::$createReflectionHandlers[$className. "_reflection"];
		return $handler($instance);
	}
	public static function init()
	{
		TypeName::init();
	}

}

