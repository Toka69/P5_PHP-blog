<?php

namespace Lib\Router;

use Symfony\Component\HttpFoundation\Request;

/**
 * Router
 */
class Router
{
    private array $routes;
    
    /**
     * add
     *
     * @param  mixed $route
     * @return void
     */
    public function add(Route $route): void 
    {
        $this->routes[] = $route;
    }
    
    /**
     * match
     *
     * @param  mixed $request
     * @return Route
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
     * generate
     *
     * @param  mixed $name
     * @return string
     */
    public function generate(string $name): string
    {
        foreach($this->routes as $route)
        {
            if ($route->getName() === $name)
            {
                return $route->getPath();
            }
        }
    }    
}
