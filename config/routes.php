<?php

use App\Controller\{
    CommentsController,
    HomeController,
    BlogController,
    BackofficeController,
    PostsController,
    SecurityController,
    UsersController
    };
use Lib\Router\Route;

return [
    // Home
    new Route("home", "/", HomeController::class, "home"),
    new Route("home", "/home", HomeController::class, "home"),
    new Route("urlError", "/url-error", HomeController::class, "urlError"),
    // Blog
    new Route("posts", "/posts", BlogController::class, "posts"),
    new Route("post", "/post", BlogController::class, "post"),
    // Backoffice
    new Route("backofficeSettings", "/back-settings", BackofficeController::class, "backofficeSettings"),
    new Route("backoffice", "/back", BackofficeController::class, "backoffice"),
    // Users
    new Route("backofficeUsers", "/back-users", UsersController::class, "backofficeUsers"),
    new Route("profile", "/profile", UsersController::class, "readUser"),
    new Route("profileEdit", "/profile-edit", UsersController::class, "editUser"),
    // Posts
    new Route("readPost", "/back-read-post", PostsController::class, "readPost"),
    new Route("editPost", "/back-edit-post", PostsController::class, "editPost"),
    new Route("backofficePosts", "/back-posts", PostsController::class, "backofficePosts"),
    // Comments
    new Route("backofficeComment", "/back-comment", CommentsController::class, "backofficeComment"),
    new Route("backofficeComments", "/back-comments", CommentsController::class, "backofficeComments"),
    // Connexion
    new Route("login", "/login", SecurityController::class, "login"),
    new Route("register", "/register", SecurityController::class, "register"),
    new Route("forgotPassword", "/forgot-password", SecurityController::class, "forgotPassword"),
    new Route("logout", "/logout", SecurityController::class, "logout")
];
