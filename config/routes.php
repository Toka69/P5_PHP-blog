<?php

use App\Controller\{
    HomeController,
    BlogController,
    BackofficeController
};
use Lib\Router\Route;

return [
    new Route("home", "/", HomeController::class, "home"),
    new Route("post", "/posts", BlogController::class, "posts"),
    new Route("post", "/post", BlogController::class, "post"),
    new Route("admin", "/back", BackofficeController::class, "backoffice"),
    new Route("admin", "/back-users", BackofficeController::class, "backofficeUsers"),
    new Route("admin", "/back-posts", BackofficeController::class, "backofficePosts"),
    new Route("admin", "/back-comments", BackofficeController::class, "backofficeComments"),
    new Route("admin", "/back-settings", BackofficeController::class, "backofficeSettings"),
    new Route("admin", "/login", BackofficeController::class, "login"),
    new Route("admin", "/register", BackofficeController::class, "register"),
    new Route("admin", "/forgot-password", BackofficeController::class, "forgotPassword")
];
