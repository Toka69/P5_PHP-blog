<?php

use App\Controller\{
    HomeController,
    BlogController
};
use Lib\Router\Route;

return [
    new Route("home", "/", HomeController::class, "home"),
    new Route("post", "/posts", BlogController::class, "")
];