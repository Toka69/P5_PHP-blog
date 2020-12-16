<?php

namespace Lib;

use Lib\Router\Router;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

/**
 * Class Kernel
 * @package Lib
 */
class Kernel
{
    /**
     * @return Response
     */
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

        if(isset($_SESSION["codeHttp"])){
            http_response_code($_SESSION["codeHttp"]);
        }

        try{
            if (!isset($_SESSION["user"])){
                $_SESSION["user"] = null;
            }
            if (!isset($_SESSION["codeHttp"])){
                $_SESSION["codeHttp"] = null;
            }
            $router->errorResponse($router->get($request->getPathInfo()), $_SESSION["user"], $_SESSION["codeHttp"]);
        }
        catch(Throwable $e){
            if ($e->getCode() != null)
            {
                http_response_code($e->getCode());
                $_SESSION["messageHttpResponseCode"] = $e->getMessage();
                $route = $router->get('notFound');
            }
        }

        $controller = $route->getController();      //get the name of the class to instantiate
        $controller = new $controller($router);     //exec config/routes.php

        return call_user_func_array([$controller, $route->getAction()], [$request]);
    }
}
