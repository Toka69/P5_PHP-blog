<?php

use App\Controller\{
    HomeController,
    BlogController,
    BackofficeController,
    SecurityController
};
use Lib\Router\Route;

return [
    new Route("home", "/", HomeController::class, "home"),
    new Route("notexist", "/notexist", HomeController::class, "notexist"),
    new Route("posts", "/posts", BlogController::class, "posts"),
    new Route("post", "/post", BlogController::class, "post"),
    new Route("backoffice", "/back", BackofficeController::class, "backoffice"),
    new Route("backofficeUsers", "/back-users", BackofficeController::class, "backofficeUsers"),
    new Route("backofficePosts", "/back-posts", BackofficeController::class, "backofficePosts"),
    new Route("backofficeComments", "/back-comments", BackofficeController::class, "backofficeComments"),
    new Route("backofficeSettings", "/back-settings", BackofficeController::class, "backofficeSettings"),
    new Route("login", "/login", SecurityController::class, "login"),
    new Route("register", "/register", SecurityController::class, "register"),
    new Route("forgotPassword", "/forgot-password", SecurityController::class, "forgotPassword"),
    new Route("logout", "/logout", SecurityController::class, "logout")
];
