<?php
namespace Lib;

use Lib\Router\Router;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Kernel
{
    public function run(): Response
    {
        $request  = Request::createFromGlobals();

        $routes = require __DIR__ . '/../config/routes.php';

        $router = new Router();

        foreach($routes as $route)
        {
            $router->add($route);
        }

        $route = $router->match($request);

        $controller = $route->getController();
        
        $controller = new $controller($router);

        return call_user_func_array([$controller, $route->getAction()], [$request]);
    }
}