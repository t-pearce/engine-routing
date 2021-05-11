<?php

namespace Engine\Routing;

abstract class RouteFactory extends \Engine\Traits\Factory
{
	/**
	 * @return Route[]
	 */
	public function getAllRoutes() : array
	{
		return $this->getAll();
	}

	public function getRoute(string $route) : Route
	{
		return $this->get($route);
	}

	/**
	 * @return Route[]
	 */
	protected function defineObjects(): array
	{
		return $this->defineRoutes();
	}

	/**
	 * @return Route[]
	 */
	abstract protected function defineRoutes() : array;
}