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
    new Route("home", "/home", HomeController::class, "home"),
    new Route("urlError", "/url-error", HomeController::class, "urlError"),
    new Route("posts", "/posts", BlogController::class, "posts"),
    new Route("post", "/post", BlogController::class, "post"),
    new Route("backoffice", "/back", BackofficeController::class, "backoffice"),
    new Route("readUser", "/back-read-user", BackofficeController::class, "readUser"),
    new Route("editUser", "/back-edit-user", BackofficeController::class, "editUser"),
    new Route("backofficeUsers", "/back-users", BackofficeController::class, "backofficeUsers"),
    new Route("readPost", "/back-read-post", BackofficeController::class, "readPost"),
    new Route("editPost", "/back-edit-post", BackofficeController::class, "editPost"),
    new Route("backofficePosts", "/back-posts", BackofficeController::class, "backofficePosts"),
    new Route("backofficeComment", "/back-comment", BackofficeController::class, "backofficeComment"),
    new Route("backofficeComments", "/back-comments", BackofficeController::class, "backofficeComments"),
    new Route("backofficeSettings", "/back-settings", BackofficeController::class, "backofficeSettings"),
    new Route("login", "/login", SecurityController::class, "login"),
    new Route("register", "/register", SecurityController::class, "register"),
    new Route("forgotPassword", "/forgot-password", SecurityController::class, "forgotPassword"),
    new Route("logout", "/logout", SecurityController::class, "logout")
];
