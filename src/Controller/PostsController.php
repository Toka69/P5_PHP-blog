<?php


namespace App\Controller;


use Symfony\Component\HttpFoundation\Response;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class PostsController extends BackofficeController
{
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
}