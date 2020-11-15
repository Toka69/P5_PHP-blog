<?php

use App\Controller\{
    HomeController,
    BlogController
};
use Lib\Router\Route;

return [
    new Route("home", "/", HomeController::class, "home"),
    new Route("posts", "/posts", BlogController::class, "posts"),
    new Route("post", "/post", BlogController::class, "post")
];
