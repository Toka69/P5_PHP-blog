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
    new Route("notFound", "/notFound", HomeController::class, "notFound"),
    new Route("contact", "/contact", HomeController::class, "contact"),
    // Blog
    new Route("posts", "/posts", BlogController::class, "posts"),
    new Route("post", "/post", BlogController::class, "post"),
    new Route("postConfirm", "/post-confirm", BlogController::class, "postConfirm"),
    // Backoffice
    new Route("backoffice", "/back", BackofficeController::class, "backoffice"),
    // Users
    new Route("backofficeAdminUsers", "/back-users", UsersController::class, "backofficeAdminUsers"),
    new Route("backofficeProfile", "/profile", UsersController::class, "readProfile"),
    new Route("backofficeProfileEdit", "/profile-edit", UsersController::class, "editProfile"),
    new Route("backofficeAdminSelectAdmin", "/select-admin", UsersController::class, "selectAdmin"),
    new Route("backofficeAdminValidUser", "/valid-user", UsersController::class, "validUser"),
    // Posts
    new Route("backofficeAdminReadPost", "/back-read-post", PostsController::class, "readPost"),
    new Route("backofficeAdminEditPost", "/back-edit-post", PostsController::class, "editPost"),
    new Route("backofficeAdminDeletePost", "/back-delete-post", PostsController::class, "deletePost"),
    new Route("backofficeAdminAddPost", "/back-add-post", PostsController::class, "addPost"),
    new Route("backofficeAdminPosts", "/back-posts", PostsController::class, "backofficePosts"),
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
