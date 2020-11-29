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
        if (!isset($_SESSION["user"])){return $this->redirect("login");}
        $id = $_SESSION['user']->getId();
        $admin = $_SESSION['user']->getAdmin();

        return $this->render("backofficeDashboard.html.twig", [
            "postsCount" => $this->postsManager->count(),
            "usersCount" => $this->usersManager->count(),
            "commentsCount" => $this->commentsManager->count($id, $admin)
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
        if (!isset($_SESSION["user"])){return $this->redirect("login");}

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
        if (!isset($_SESSION["user"])){return $this->redirect("login");}
        $id = $_SESSION["user"]->getId();

        if($_SERVER ["REQUEST_METHOD"] == "POST")
        {
            $user = $this->usersManager->getUser($id);
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
                $user->setPseudo($_POST["pseudo"]);
                $user->setGenderId($_POST["genderId"]);
                $this->usersManager->update($user);
                $_SESSION['user'] = $this->usersManager->getUser($id);

                return $this->redirect("profile");
            }

            return $this->render("profile.html.twig", [
                "user" => $user,
                "errors" => $errors,
                "genders" => $this->usersManager->getGenders(),
                "disabled" => null
            ]);
        }

        if (isset($_GET["edit"]))
        {
                return $this->render("profile.html.twig", [
                    "user" => $this->usersManager->getUser($id),
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
        if (!isset($_SESSION["user"])){return $this->redirect("login");}

        if (isset($_SESSION["user"]) && ($_SESSION["user"]) != null)
        {
            return $this->render("profile.html.twig", [
                "user" => $_SESSION["user"],
                "genders" => $this->usersManager->getGenders(),
                "disabled" => "disabled"
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
    public function backofficePosts(): Response
    {
        if (!isset($_SESSION["user"])){return $this->redirect("login");}

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
        if (!isset($_SESSION["user"])){return $this->redirect("login");}
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
        if (!isset($_SESSION["user"])){return $this->redirect("login");}
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
        if (!isset($_SESSION["user"])){return $this->redirect("login");}
        $id = $_SESSION['user']->getId();
        $admin = $_SESSION['user']->getAdmin();

        return $this->render("backofficeComments.html.twig", [
            "commentsList" => $this->commentsManager->getList($id, $admin)
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
        if (!isset($_SESSION["user"])){return $this->redirect("login");}
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
        if (!isset($_SESSION["user"])){return $this->redirect("login");}

        return $this->render("backofficeSettings.html.twig");
    }

}
