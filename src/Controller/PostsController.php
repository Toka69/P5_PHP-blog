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
        $errors = [];

        $post = $this->exist($_GET["id"], "post");

        if ($post == null)
        {
            return $this->errorResponse(400);
        }

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
                $post->setTitle($_POST["title"]);
                $post->setLeadParagraph($_POST["leadParagraph"]);
                $post->setContent($_POST["content"]);
                $post->setUserID($_POST["userId"]);
                $this->postsManager->update($post);

                return $this->redirect("backofficePosts");
            }
        }

        return $this->render("backofficePost.html.twig", [
            "post" => $post,
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
        $post = $this->exist($_GET["id"], "post");

        if ($post == null)
        {
            return $this->errorResponse(400);
        }

        return $this->render("backofficePost.html.twig", [
            "post" => $this->postsManager->getPost($_GET["id"]),
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
        $post = $this->exist($_GET["id"], "post");
        $comments = $this->commentsManager->getCommentsPost($post->getId());
        foreach ($comments as $comment)
        {
            $this->commentsManager->delete($comment);
        }
        $this->postsManager->delete($post);

        return $this->redirect("backofficePosts");
    }
}