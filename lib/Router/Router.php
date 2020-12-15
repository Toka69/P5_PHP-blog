<?php

namespace Lib\Router;

use Exception;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class Router
 * @package Lib\Router
 */
class Router
{
    private array $routes;

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
                return $route->getPath();
            }
        }
    }

    /**
     * @param string $name
     * @return Route
     */
    public function get(string $name): ?Route
    {
        foreach ($this->routes as $route)
        {
            if ($route->getName() === $name)
            {
                return $route;
            }
            if ($route->getPath() === $name)
            {
                return $route;
            }
        }

        return null;
    }

    public function errorResponse(?object $route = null, ?object $session = null, ?int $codeHttp = null)
    {
        unset($_SESSION["codeHttp"]);

        if (is_null($route))
        {
            throw new Exception('Cet adresse n\'existe pas', 404);
        }
        if (is_null($session) && strpos($route->getName(), "backoffice") !== false)
        {
            throw new Exception('Accès refusé. Nécessite une authentification', 401);
        }
        if (isset($codeHttp))
        {
            switch($codeHttp)
            {
                case 400:
                    throw new Exception('Mauvaise requête', $codeHttp);
                case 401:
                    throw new Exception('Accès refusé. Nécessite une authentification', $codeHttp);
                case 404:
                    throw new Exception('Cet adresse n\'existe pas', $codeHttp);
                default:
                    throw new Exception('Exception', $codeHttp);
            }
        }
        return null;
    }
}
