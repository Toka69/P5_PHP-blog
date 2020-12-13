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
    new Route("index", "/", HomeController::class, "home"),
    new Route("home", "/home", HomeController::class, "home"),
    new Route("urlError", "/url-error", HomeController::class, "urlError"),
    new Route("notFound", "/404", HomeController::class, "notFound"),
    new Route("contact", "/contact", HomeController::class, "contact"),
    // Blog
    new Route("posts", "/posts", BlogController::class, "posts"),
    new Route("post", "/post", BlogController::class, "post"),
    // Backoffice
    new Route("backoffice", "/back", BackofficeController::class, "backoffice"),
    // Users
    new Route("backofficeUsers", "/back-users", UsersController::class, "backofficeUsers"),
    new Route("backofficeProfile", "/profile", UsersController::class, "readUser"),
    new Route("backofficeProfileEdit", "/profile-edit", UsersController::class, "editUser"),
    new Route("backofficeSelectAdmin", "/select-admin", UsersController::class, "selectAdmin"),
    new Route("backofficeValidUser", "/valid-user", UsersController::class, "validUser"),
    // Posts
    new Route("backofficeReadPost", "/back-read-post", PostsController::class, "readPost"),
    new Route("backofficeEditPost", "/back-edit-post", PostsController::class, "editPost"),
    new Route("backofficeDeletePost", "/back-delete-post", PostsController::class, "deletePost"),
    new Route("backofficeAddPost", "/back-add-post", PostsController::class, "addPost"),
    new Route("backofficePosts", "/back-posts", PostsController::class, "backofficePosts"),
    // Comments
    new Route("backofficeReadComment", "/back-read-comment", CommentsController::class, "readComment"),
    new Route("backofficeEditComment", "/back-edit-comment", CommentsController::class, "editComment"),
    new Route("backofficeAddComment", "/back-add-comment", CommentsController::class, "addComment"),
    new Route("backofficeComments", "/back-comments", CommentsController::class, "backofficeComments"),
    // Connexion
    new Route("login", "/login", SecurityController::class, "login"),
    new Route("register", "/register", SecurityController::class, "register"),
    new Route("forgotPassword", "/forgot-password", SecurityController::class, "forgotPassword"),
    new Route("logout", "/logout", SecurityController::class, "logout"),
    new Route("validAccount", "/valid-account", SecurityController::class, "validAccount")
];
