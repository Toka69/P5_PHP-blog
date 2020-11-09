<?php


namespace App\Controller;

use App\Manager\CommentsManager;
use App\Manager\PostsManager;
use App\Manager\UsersManager;
use Lib\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class BackofficeController
 * @package App\Controller
 */
class BackofficeController extends AbstractController
{
    /**
     * @return Response
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function login(): Response
    {
        return $this->render("login.html.twig");
    }

    /**
     * @return Response
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function register(): Response
    {
        return $this->render("register.html.twig");
    }

    /**
     * @return Response
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function forgotPassword(): Response
    {
        return $this->render("forgot-password.html.twig");
    }

    /**
     * @return Response
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function backoffice(): Response
    {
        $postManager = new PostsManager();
        $postsCount = $postManager->count();
        $usersManager = new UsersManager();
        $usersCount = $usersManager->count();
        $commentsManager = new CommentsManager();
        $commentsCount = $commentsManager->count();

        return $this->render("backofficeDashboard.html.twig", [
            "postsCount" => $postsCount,
            "usersCount" => $usersCount,
            "commentsCount" => $commentsCount
        ]);
    }

    /**
     * @return Response
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function backofficeUsers(): Response
    {
        $manager = new UsersManager();
        $usersList = $manager->getList(0, 10);

        return $this->render("backofficeUsers.html.twig", [
            "usersList" => $usersList
        ]);
    }

    /**
     * @return Response
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function backofficePosts(): Response
    {
        $manager = new PostsManager();
        $postsList = $manager->getList(0, 10);

        return $this->render("backofficePosts.html.twig", [
            "postsList" => $postsList
        ]);
    }

    /**
     * @return Response
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function backofficeComments(): Response
    {
        $manager = new CommentsManager();
        $commentsList = $manager->getList();

        return $this->render("backofficeComments.html.twig", [
            "commentsList" => $commentsList
        ]);
    }

    /**
     * @return Response
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function backofficeSettings(): Response
    {
        return $this->render("backofficeSettings.html.twig");
    }
}
