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

        return $this->render("backofficeUsers.html.twig", [
            "usersList" => $usersList
        ]);
    }

    public function backofficeUser(): Response
    {
        $manager = new UsersManager($this->PDOConnection());
        if (isset($_GET['id']) && preg_match('#^[0-9]+$#', $_GET['id']))
        {
            $securForm = $this->securForm($_GET);
            $user = $manager->getUser($securForm['id']);
            $genders = $manager->getGenders();
            if ($user)
            {
                return $this->render("backofficeUser.html.twig", [
                    "user" => $user,
                    "genders" => $genders,
                    "disabled" => "disabled"
                ]);
            }
        }

        return $this->redirect('backofficeUsers');
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

        if (isset($_GET['id'])) {
            $securForm = $this->securForm($_GET);
            if (preg_match('#^[0-9]+$#', $securForm['id']) && $manager->getSinglePost($securForm['id']))
            {
                return $this->render("backofficepost.html.twig", [
                    "id" => (int)$securForm['id']
                ]);
            }

            return $this->redirect('backofficePosts');
        }

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

        if (isset($_GET['id'])) {
            $securForm = $this->securForm($_GET);
            if (preg_match('#^[0-9]+$#', $securForm['id']) && $manager->getComment($securForm['id']) || $manager->getComment($securForm['id']))
            {
                return $this->render("backofficecomment.html.twig", [
                    "id" => (int)$securForm['id']
                ]);
            }

            return $this->redirect('backofficeComments');
        }

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
