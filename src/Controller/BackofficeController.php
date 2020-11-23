<?php

namespace App\Controller;

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
        $postsCount = $this->postsManager->count();
        $usersCount = $this->usersManager->count();
        $commentsCount = $this->commentsManager->count();

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
        $usersList = $this->usersManager->getList();

        return $this->render("backofficeUsers.html.twig", [
            "usersList" => $usersList
        ]);
    }

    public function backofficeUser(): Response
    {
        if (isset($_GET['id']) && preg_match('#^[0-9]+$#', $_GET['id']))
        {
            $securForm = $this->securForm($_GET);
            $user = $this->usersManager->getUser($securForm['id']);
            $genders = $this->usersManager->getGenders();

            if (isset($_GET['edit']))
            {
                $disabled = null;
            }
            else
            {
                $disabled = 'disabled';
            }

            if ($user)
            {
                return $this->render("backofficeUser.html.twig", [
                    "user" => $user,
                    "genders" => $genders,
                    "disabled" => $disabled
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
        $postsList = $this->postsManager->getList();

        if (isset($_GET['id'])) {
            $securForm = $this->securForm($_GET);
            if (preg_match('#^[0-9]+$#', $securForm['id']) && $this->postsManager->getSinglePost($securForm['id']))
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
        $commentsList = $this->commentsManager->getList();

        if (isset($_GET['id'])) {
            $securForm = $this->securForm($_GET);
            if (preg_match('#^[0-9]+$#', $securForm['id']) && $this->commentsManager->getComment($securForm['id']) || $this->commentsManager->getComment($securForm['id']))
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
