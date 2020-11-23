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
        return $this->render("backofficeDashboard.html.twig", [
            "postsCount" => $this->postsManager->count(),
            "usersCount" => $this->usersManager->count(),
            "commentsCount" => $this->commentsManager->count()
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
        return $this->render("backofficeUsers.html.twig", [
            "usersList" => $this->usersManager->getList()
        ]);
    }

    /**
     * @return Response
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function backofficeUser(): Response
    {
        if (isset($_GET['id']) && preg_match('#^[0-9]+$#', $_GET['id']))
        {
            $secureForm = $this->secureForm($_GET);
            if (isset($_GET['edit']))
            {
                $disabled = null;
            }
            else
            {
                $disabled = 'disabled';
            }

            if ($this->usersManager->getUser($secureForm['id']))
            {
                return $this->render("backofficeUser.html.twig", [
                    "user" => $this->usersManager->getUser($secureForm['id']),
                    "genders" => $this->usersManager->getGenders(),
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
        return $this->render("backofficePosts.html.twig", [
            "postsList" => $this->postsManager->getList()
        ]);
    }

    public function backofficePost(): Response
    {
        if (isset($_GET['id']) && preg_match('#^[0-9]+$#', $_GET['id']))
        {
            $secureForm = $this->secureForm($_GET);
            if (isset($_GET['edit']))
            {
                $disabled = null;
            }
            else
            {
                $disabled = 'disabled';
            }

            if ($this->postsManager->getSinglePost($secureForm['id']))
            {
                return $this->render("backofficePost.html.twig", [
                    "post" => $this->postsManager->getSinglePost($secureForm['id']),
                    "usersAdmin" => $this->usersManager->getList("admin"),
                    "disabled" => $disabled
                ]);
            }
        }

        return $this->redirect('backofficePosts');
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
            $secureForm = $this->secureForm($_GET);
            if (preg_match('#^[0-9]+$#', $secureForm['id']) && $this->commentsManager->getComment($secureForm['id']) || $this->commentsManager->getComment($secureForm['id']))
            {
                return $this->render("backofficeComment.html.twig", [
                    "id" => (int)$secureForm['id']
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
