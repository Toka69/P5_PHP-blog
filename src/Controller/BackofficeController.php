<?php

namespace App\Controller;

use App\Manager\CommentsManager;
use App\Manager\PostsManager;
use App\Manager\UsersManager;
use Lib\AbstractController;
use Lib\PDOSingleton;
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
        $db = PDOSingleton::getInstance()->getPDO();
        $postManager = new PostsManager($db);
        $postsCount = $postManager->count();
        $usersManager = new UsersManager($db);
        $usersCount = $usersManager->count();
        $commentsManager = new CommentsManager($db);
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
        $db = PDOSingleton::getInstance()->getPDO();
        $manager = new UsersManager($db);
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
        $db = PDOSingleton::getInstance()->getPDO();
        $manager = new PostsManager($db);
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
        $db = PDOSingleton::getInstance()->getPDO();
        $manager = new CommentsManager($db);
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
