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
        $postManager = new PostsManager($this->PDOConnection());
        $postsCount = $postManager->count();
        $usersManager = new UsersManager($this->PDOConnection());
        $usersCount = $usersManager->count();
        $commentsManager = new CommentsManager($this->PDOConnection());
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
        $manager = new UsersManager($this->PDOConnection());
        $usersList = $manager->getList();

        if (isset($_GET['id']))
        {
            if (preg_match('#^[0-9]+$#', $_GET['id'])) {
                $securForm = $this->securForm($_GET);
                if (is_int((int)$securForm['id'])) {
                    return $this->render("backofficeUser.html.twig", [
                        "id" => (int)$securForm['id']
                    ]);
                }
            }

            return $this->redirect('backofficeUsers');
        }

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
        $manager = new PostsManager($this->PDOConnection());
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
        $manager = new CommentsManager($this->PDOConnection());
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
