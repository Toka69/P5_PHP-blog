<?php


namespace App\Controller;


use App\Entity\Comment;
use Psr\Log\InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class CommentsController
 * @package App\Controller
 */
class CommentsController extends BackofficeController
{
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
    public function readComment(): Response
    {
        if (!isset($_SESSION["user"])){return $this->redirect("login");}
        $secureRequestMethod = $this->secureRequestMethod($_GET);
        if (isset($_GET["id"]) && preg_match("#^[0-9]+$#", $_GET["id"]) && $this->commentsManager->getComment($secureRequestMethod["id"]))
        {
            return $this->render("backofficeComment.html.twig", [
                "comment" => $this->commentsManager->getComment($secureRequestMethod["id"]),
                "disabled" => "disabled"
            ]);
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
    public function editComment(): Response
    {
        if (!isset($_SESSION["user"])){return $this->redirect("login");}
        $authorizeEdit = isset($_GET["id"]) && preg_match("#^[0-9]+$#", $_GET["id"]);
        $secureRequestMethod = $this->secureRequestMethod($_GET);
        $errors = [];

        if ($authorizeEdit)
        {
            $id = $secureRequestMethod["id"];
        }
        if (isset($_SESSION["commentId"]))
        {
            $id = $_SESSION["commentId"];
        }
        $comment = $this->commentsManager->getComment($id);

        if(is_null($comment))
        {
            throw new InvalidArgumentException('400 Bad request');
            //return $this->redirect('urlError');
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST")
        {
            $owner = true;
            $message = "";
            $disabled = null;

            if (isset($_POST['message'])){$message = $_POST["message"];}
            if ($_SESSION["user"]->getId() !== $comment->getUserID())
            {
                $message = $comment->getMessage();
                $owner = false;
            }
            if (!isset($_POST["message"]) || $_POST["message"] == "" && $owner == true)
            {
                $errors["message"]= "Veuillez écrire un message";
            }
            if (!isset($_POST["valid"]) || $_POST["valid"] == null)
            {
                $errors["valid"]= "Veuillez sélectionner si le commentaire est valide";
            }

            if (count($errors) === 0)
            {
                $comment->setMessage($message);
                $comment->setValid($_POST["valid"]);
                $comment->setModifiedDate(date("Y-m-d H:i:s"));
                $this->commentsManager->update($comment);
                $disabled = "disabled";
            }
            $_SESSION["comment"] = $comment;
            $_SESSION["errors"] = $errors;
            $_SESSION["disabled"] = $disabled;
            $_SESSION["commentId"] = $id;

            return $this->redirect("editComment");
        }

        if (isset($_GET["edit"]) && $authorizeEdit)
        {
            $_SESSION["comment"] = $comment;
            $_SESSION["errors"] = $errors;
            $_SESSION["disabled"] = null;
        }

        return $this->render("backofficeComment.html.twig", [
            "comment" => $_SESSION["comment"],
            "errors" => $_SESSION["errors"],
            "disabled" => $_SESSION["disabled"]
        ]);
    }

    /**
     * @return Response
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function addComment(): Response
    {
        if (!isset($_SESSION["user"])){return $this->redirect("login");}
        if ($_SERVER["REQUEST_METHOD"] == "POST")
        {
            $errors = [];
            if (!isset($_POST["message"]) || $_POST["message"] == "")
            {
                $errors["message"]= "Veuillez écrire un message";
            }

            if (count($errors) === 0)
            {
                $array = [
                    'message' => $_POST['message'],
                    'postsId' => $_GET['postId'],
                    'userId' => $_SESSION['user']->getId()
                ];
                $comment = new Comment($array);
                $this->commentsManager->add($comment);

                return $this->redirect("posts");
            }

            return $this->render("post.html.twig", [
                "errors" => $errors
            ]);
        }

        return $this->redirect("posts");
    }
}