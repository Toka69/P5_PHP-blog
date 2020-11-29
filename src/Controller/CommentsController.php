<?php


namespace App\Controller;


use Symfony\Component\HttpFoundation\Response;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

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

        if ($_SERVER["REQUEST_METHOD"] == "POST" && $authorizeEdit)
        {
            $comment = $this->commentsManager->getComment($_GET["id"]);
            $errors = [];
            $owner = true;

            if (isset($_POST['message'])){$message = $_POST["message"];};
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

                return $this->redirect("backofficeComments");
            }

            return $this->render("backofficeComment.html.twig", [
                "comment" => $comment,
                "errors" => $errors,
                "disabled" => null
            ]);
        }

        if (isset($_GET["edit"]) && $authorizeEdit)
        {
            return $this->render("backofficeComment.html.twig", [
                "comment" => $this->commentsManager->getComment($secureRequestMethod["id"]),
                "disabled" => null
            ]);
        }

        return $this->redirect("backofficeComments");
    }
}