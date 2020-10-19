<?php

use App\Controller\{
    HomeController,
    BlogController
};
use Lib\Router\Route;

return [
    new Route("home", "/", HomeController::class, "home"),  //(name, path, controllerClass, methode)
    new Route("post", "/posts", BlogController::class, "test")  //need update
];