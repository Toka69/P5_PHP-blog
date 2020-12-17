<?php


namespace App\Controller;


use App\Entity\Comment;
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
        $id = $this->superGlobalObject->session['user']->getId();
        $admin = $this->superGlobalObject->session['user']->getAdmin();

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
        $comment = $this->exist($this->superGlobalObject->get["id"], "comment");

        if ($comment == null)
        {
            return $this->errorResponse(400);
        }

        return $this->render("backofficeComment.html.twig", [
            "post" => $this->postsManager->getPost($comment->getPostsId()),
            "comment" => $comment,
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
    public function editComment(): Response
    {
        $comment = $this->exist($this->superGlobalObject->get["id"], "comment");

        if ($comment == null)
        {
            return $this->errorResponse(400);
        }

        $errors = [];

        if ($_SERVER["REQUEST_METHOD"] == "POST")
        {
            $owner = true;
            $message = "";

            if (isset($this->superGlobalObject->post['message'])){$message = $this->superGlobalObject->post["message"];}
            if ($this->superGlobalObject->session["user"]->getId() !== $comment->getUserID())
            {
                $message = $comment->getMessage();
                $owner = false;
            }
            if ((!isset($this->superGlobalObject->post["message"]) || $this->superGlobalObject->post["message"] == "") && $owner == true)
            {
                $errors["message"]= "Veuillez écrire un message";
            }
            if (!isset($this->superGlobalObject->post["valid"]) || $this->superGlobalObject->post["valid"] == null)
            {
                $errors["valid"]= "Veuillez sélectionner si le commentaire est valide";
            }

            if (count($errors) === 0)
            {
                $comment->setMessage($message);
                $comment->setValid($this->superGlobalObject->post["valid"]);
                $comment->setModifiedDate(date("Y-m-d H:i:s"));
                $this->commentsManager->update($comment);

                return $this->redirect("backofficeComments");
            }
        }

        return $this->render("backofficeComment.html.twig", [
            "post" => $this->postsManager->getPost($comment->getPostsId()),
            "comment" => $comment,
            "errors" => $errors,
            "disabled" => null
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
        $errors = [];

        if ($_SERVER["REQUEST_METHOD"] == "POST")
        {
            if (count($errors) === 0)
            {
                $array = [
                    'message' => $this->superGlobalObject->post['message'],
                    'postsId' => $this->superGlobalObject->get['postId'],
                    'userId' => $this->superGlobalObject->session['user']->getId()
                ];
                $comment = new Comment($array);
                $this->commentsManager->add($comment);
                $this->sendEmail($_ENV["MAIL_NOTIFICATION"], "Nouveau commentaire",
                    "Un nouveau commentaire a été posté. Connectez-vous pour le valider!
                    http://".$_SERVER["HTTP_HOST"]."/back");

                //return $this->render("postConfirm.html.twig");
                return $this->redirect("postConfirm");
            }
        }

        return $this->redirect("posts");
    }
}