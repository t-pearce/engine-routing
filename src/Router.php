<?php

namespace Engine\Routing;

class Router
{
	use \Engine\Traits\Singleton;

	/** @var RouteFactory[] */
	private array $routeFactories = [];

	public final function __construct() { }

	public function addRouteFactory(RouteFactory $factory) : self
	{
		$this->routeFactories[] = $factory;

		return $this;
	}

	/**
	 * @param RouteFactory[] $factories
	 */
	public function addRouteFactories(array $factories) : self
	{
		foreach($factories as $factory)
		{
			$this->addRouteFactory($factory);
		}

		return $this;
	}

	public function canHandleRoute(string $routeString) : bool
	{
		foreach($this->routeFactories as $factory)
		{
			foreach($factory->getAllRoutes() as $route)
			{
				if($route->isRouteFor($routeString))
					return true;
			}
		}

		return false;
	}

	public function route(string $routeString) : ?\Engine\Page\Page
	{
		foreach($this->routeFactories as $factory)
		{
			foreach($factory->getAllRoutes() as $route)
			{
				if($route->isRouteFor($routeString))
					return $route->getPage();
			}
		}
		
		return null;
	}

	/**
	 * @return Route[]
	 */
	public function getAllRoutes() : array
	{
		$routes = [];

		foreach($this->routeFactories as $factory)
		{
			foreach($factory->getAllRoutes() as $route)
			{
				$routes[] = $route;
			}
		}

		return $routes;
	}
}