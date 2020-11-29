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
}