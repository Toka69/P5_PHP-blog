<?php
namespace Lib\Router;

use Symfony\Component\HttpFoundation\Request;

class Router
{
    private array $_routes;

    public function add(Route $route): void 
    {
        $this->_routes[] = $route;
    }

    public function match(Request $request): ?Route
    {
        foreach ($this->_routes as $route) 
        {
            if ($request->getPathInfo() === $route->getPath())  //getPathInfo() provides the url without query param
            {
                return $route;
            }
        }

        return null;
    }

    public function generate(string $name): string
    {
        foreach($this->_routes as $route)
        {
            if ($route->getName() === $name)
            {
                return $route->getPath();
            }
        }
    }
    
}