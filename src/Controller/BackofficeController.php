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
    public function backoffice(): Response
    {
        $postManager = new PostsManager(self::PDOConnection());
        $postsCount = $postManager->count();
        $usersManager = new UsersManager(self::PDOConnection());
        $usersCount = $usersManager->count();
        $commentsManager = new CommentsManager(self::PDOConnection());
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
        $manager = new UsersManager(self::PDOConnection());
        $usersList = $manager->getList();

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
        $manager = new PostsManager(self::PDOConnection());
        $postsList = $manager->getList();

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
        $manager = new CommentsManager(self::PDOConnection());
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
