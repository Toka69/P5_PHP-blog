<?php
namespace Lib\Router;

use Symfony\Component\HttpFoundation\Request;

class Router
{
    /**
     * @var array<Route>
     */
    private array $outes;

    /**
     *  @param Route $route
     */
    public function add(Route $route): void 
    {
        $this->routes[] = $route;
    }

    public function match(Request $request): ?Route
    {
        foreach ($this->routes as $route) {
            if ($request->getPathInfo() === $route->getPath()) {
                return $route;
            }
        }

        return null;
    }
    
}