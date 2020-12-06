<?php


namespace App\Controller;


use App\Entity\Post;
use Symfony\Component\HttpFoundation\Response;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class PostsController
 * @package App\Controller
 */
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
        $authorize = isset($_GET["id"]) && preg_match("#^[0-9]+$#", $_GET["id"]);
        $secureRequestMethod = $this->secureRequestMethod($_GET);
        $errors = [];
        $post = null;

        if($authorize)
        {
            $post = $this->postsManager->getSinglePost($_GET["id"]);
        }

        $this->errorResponse($post, 400);

        if ($_SERVER["REQUEST_METHOD"] == "POST" && $authorize)
        {
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
                $post->setUserID($_POST["userId"]);
                $this->postsManager->update($post);

                return $this->redirect("backofficePosts");
            }
        }

        return $this->render("backofficePost.html.twig", [
            "post" => $this->postsManager->getSinglePost($secureRequestMethod["id"]),
            "errors" => $errors,
            "usersAdmin" => $this->usersManager->getList("admin"),
            "disabled" => null
        ]);
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
        $authorize = isset($_GET["id"]) && preg_match("#^[0-9]+$#", $_GET["id"]);
        $secureRequestMethod = $this->secureRequestMethod($_GET);
        $post = null;

        if ($authorize)
        {
            $post = $this->postsManager->getSinglePost($secureRequestMethod["id"]);
        }
        $this->errorResponse($post, 400);

        return $this->render("backofficePost.html.twig", [
            "post" => $this->postsManager->getSinglePost($secureRequestMethod["id"]),
            "usersAdmin" => $this->usersManager->getList("admin"),
            "disabled" => "disabled"
        ]);
    }

    /**
     * @return Response
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function addPost(): Response
    {
        if (!isset($_SESSION["user"])){return $this->redirect("login");}
        $errors = [];

        if ($_SERVER["REQUEST_METHOD"] == "POST")
        {
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
                $array = [
                    'title' => $_POST['title'],
                    'leadParagraph' => $_POST['leadParagraph'],
                    'content' => $_POST['content'],
                    'userId' => $_POST['userId']
                ];
                $post = new Post($array);
                $this->postsManager->add($post);

                return $this->redirect("backofficePosts");
            }
        }

        return $this->render("add-post.html.twig", [
            "usersAdmin" => $this->usersManager->getList("admin"),
            "errors" => $errors
        ]);
    }

    /**
     * @return Response
     */
    public function deletePost(): Response
    {
        if (!isset($_SESSION["user"])){return $this->redirect("login");}
        $post = $this->postsManager->getSinglePost($_GET["id"]);
        $comments = $this->commentsManager->getCommentsPost($post->getId());
        foreach ($comments as $comment)
        {
            $this->commentsManager->delete($comment);
        }
        $this->postsManager->delete($post);

        return $this->redirect("backofficePosts");
    }
}