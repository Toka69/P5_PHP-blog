<?php
namespace Lib;

use Lib\Router\Router;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Kernel
{
    public function run(): Response
    {
        $request  = Request::createFromGlobals();   //createFromGlobals() will create a request object with globals (post, get, server, ...)

        $routes = require __DIR__ . '/../config/routes.php';

        $router = new Router();

        foreach($routes as $route)
        {
            $router->add($route);                   //foreach route, add route object in router needed to match.
        }

        $route = $router->match($request);          //verify if route exist return route, else null.

        $controller = $route->getController();      //get the name of the class to instantiate
        
        $controller = new $controller($router);     //exec config/routes.php

        return call_user_func_array([$controller, $route->getAction()], [$request]);
    }
}