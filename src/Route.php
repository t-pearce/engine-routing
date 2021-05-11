<?php

namespace Engine\Routing;

abstract class Route
{
	use \Engine\Traits\Singleton;

	protected static string $route;

	public final function __construct()
	{
		if(!isset(static::$route))
			throw new \LogicException("Route " . static::class . " does not have a defined route");
	}

	abstract public function getPage() : \Engine\Page\Page;

	public function isRouteFor(string $route) : bool
	{
		return isset(static::$route) && static::$route === $route;
	}
}