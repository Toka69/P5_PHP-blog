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
    public function editUser(): Response
    {
        $secureRequestMethod = $this->secureRequestMethod($_GET);
        $authorizeEdit = isset($_GET["id"]) && preg_match("#^[0-9]+$#", $_GET["id"]) && $this->usersManager->getUser($secureRequestMethod["id"]);

        if($_SERVER ["REQUEST_METHOD"] == "POST" && $authorizeEdit)
        {
            $user = $this->usersManager->getUser($secureRequestMethod["id"]);
            $errors = [];
            if (!isset($_POST["firstName"]) || $_POST["firstName"] == null)
            {
                $errors["firstName"]= "Veuillez saisir votre prénom";
            }
            if (!isset($_POST["lastName"]) || $_POST["lastName"] == null)
            {
                $errors["lastName"]= "Veuillez saisir votre nom";
            }
            if (!isset($_POST["email"]) || $_POST["email"] == null)
            {
                $errors["email"]= "Veuillez saisir votre email";
            }
            if (count($errors) === 0)
            {
                $user->setFirstName($_POST["firstName"]);
                $user->setLastName($_POST["lastName"]);
                $user->setEmail($_POST["email"]);
                $this->usersManager->update($user);

                return $this->redirect("backofficeUsers");
            }

            return $this->render("backofficeUser.html.twig", [
                "user" => $user,
                "errors" => $errors,
                "genders" => $this->usersManager->getGenders(),
                "disabled" => null
            ]);
        }

        if (isset($_GET["edit"]) && $authorizeEdit)
        {
                return $this->render("backofficeUser.html.twig", [
                    "user" => $this->usersManager->getUser($secureRequestMethod["id"]),
                    "genders" => $this->usersManager->getGenders(),
                    "disabled" => null
                ]);
        }

        return $this->redirect("backofficeUsers");
    }

    /**
     * @return Response
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function readUser(): Response
    {
        $secureRequestMethod = $this->secureRequestMethod($_GET);
        if (isset($_GET["id"]) && preg_match("#^[0-9]+$#", $_GET["id"]) && $this->usersManager->getUser($secureRequestMethod["id"])) {
            return $this->render("backofficeUser.html.twig", [
                "user" => $this->usersManager->getUser($secureRequestMethod["id"]),
                "genders" => $this->usersManager->getGenders(),
                "disabled" => "disabled"
            ]);
        }

        return $this->redirect("backofficeUsers");
    }

    public function backofficePosts(): Response
    {
        return $this->render("backofficePosts.html.twig", [
            "postsList" => $this->postsManager->getList()
        ]);
    }

    /**
     * @return Response
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function editPost(): Response
    {
        $authorizeEdit = isset($_GET["id"]) && preg_match("#^[0-9]+$#", $_GET["id"]);
        $secureRequestMethod = $this->secureRequestMethod($_GET);

        if ($_SERVER["REQUEST_METHOD"] == "POST" && $authorizeEdit)
        {
            $post = $this->postsManager->getSinglePost($_GET["id"]);
            $errors = [];
            if (!isset($_POST["title"]) || $_POST["title"] == null)
            {
                $errors["title"]= "Veuillez saisir le titre";
            }
            if (!isset($_POST["leadParagraph"]) || $_POST["leadParagraph"] == null)
            {
                $errors["leadParagraph"]= "Veuillez saisir le châpo";
            }
            if (!isset($_POST["content"]) || $_POST["content"] == null)
            {
                $errors["content"]= "Veuillez saisir le contenu";
            }

            if (count($errors) === 0)
            {
                $post->setTitle($_POST["title"]);
                $post->setLeadParagraph($_POST["leadParagraph"]);
                $post->setContent($_POST["content"]);
                $post->setModifiedDate(date("Y-m-d H:i:s"));
                $post->setUserID($_POST["userId"]);
                $this->postsManager->update($post);

                return $this->redirect("backofficePosts");
            }

            return $this->render("backofficePost.html.twig", [
                "post" => $post,
                "errors" => $errors,
                "disabled" => null
            ]);
        }

        if (isset($_GET["edit"]) && $authorizeEdit)
        {
            return $this->render("backofficePost.html.twig", [
                "post" => $this->postsManager->getSinglePost($secureRequestMethod["id"]),
                "usersAdmin" => $this->usersManager->getList("admin"),
                "disabled" => null
            ]);
        }

        return $this->redirect("backofficePosts");
    }

    /**
     * @return Response
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function readPost(): Response
    {
        $secureRequestMethod = $this->secureRequestMethod($_GET);
        if (isset($_GET["id"]) && preg_match("#^[0-9]+$#", $_GET["id"]))
        {
            return $this->render("backofficePost.html.twig", [
                "post" => $this->postsManager->getSinglePost($secureRequestMethod["id"]),
                "usersAdmin" => $this->usersManager->getList("admin"),
                "disabled" => "disabled"
            ]);
        }

        return $this->redirect("backofficePosts");
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
        return $this->render("backofficeComments.html.twig", [
            "commentsList" => $this->commentsManager->getList()
        ]);
    }

    /**
     * @return Response
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function backofficeComment(): Response
    {
        if (isset($_GET["id"]) && preg_match("#^[0-9]+$#", $_GET["id"])) {
            $secureRequestMethod = $this->secureRequestMethod($_GET);
            if (isset($_GET["edit"]))
            {
                $disabled = null;
            }
            else
            {
                $disabled = "disabled";
            }
            if ($this->commentsManager->getComment($secureRequestMethod["id"])) {
                return $this->render("backofficeComment.html.twig", [
                    "comment" => $this->commentsManager->getComment($secureRequestMethod["id"]),
                    "disabled" => $disabled
                ]);
            }
        }

            return $this->redirect("backofficeComments");
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
