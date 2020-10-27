<?php

namespace Lib\Router;

use Symfony\Component\HttpFoundation\Request;

/**
 * Class Router
 * @package Lib\Router
 */
class Router
{
    private array $routes;
    private string $path;

    /**
     * @param Route $route
     */
    public function add(Route $route): void 
    {
        $this->routes[] = $route;
    }

    /**
     * @param Request $request
     * @return Route|null
     */
    public function match(Request $request): ?Route
    {
        foreach ($this->routes as $route) 
        {
            if ($request->getPathInfo() === $route->getPath())  //getPathInfo() provides the url without query param
            {
                return $route;
            }
        }

        return null;
    }

    /**
     * @param string $name
     * @return string
     */
    public function generate(string $name): string
    {
        foreach($this->routes as $route)
        {
            if ($route->getName() === $name)
            {
                $this->path = $route->getPath();
            }
        }
        return $this->path;
    }    
}
