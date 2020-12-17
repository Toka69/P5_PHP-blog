<?php

namespace App\Controller;

use Lib\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class BlogController
 * @package App\Controller
 */
class BlogController extends AbstractController
{
    /**
     * @return Response
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function posts(): Response
    {
        if (isset($this->superGlobalObject->get['page']) && !empty($this->superGlobalObject->get['page']))
        {
            $currentPage = (int) strip_tags($this->superGlobalObject->get['page']);
        }
        else
        {
            $currentPage = 1;
        }

        $pagination = $this->getPostsListPagination($currentPage);
        $postsList = $pagination["posts"];
        $nbPages = $pagination["nbPages"];

        return $this->render("posts.html.twig",[
            "postsList" => $postsList,
            "nbPages" => $nbPages,
            "currentPage" => $currentPage
        ]);
    }

    /**
     * @return Response
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function post(): Response
    {
        $post = $this->exist($this->superGlobalObject->get["id"], "post");

        if ($post == null)
        {
            return $this->errorResponse(400);
        }

        $singlePost = $this->postsManager->getPost($this->superGlobalObject->get['id']);
        $comments = $this->commentsManager->getCommentsPost($this->superGlobalObject->get['id'], 1);
        $disabled = "";
        if (!isset($this->superGlobalObject->session["user"])){
            $disabled = "disabled";
        }

        return $this->render("post.html.twig",[
            "singlePost" => $singlePost,
            "comments" => $comments,
            "disabled" => $disabled
            ]);
    }

    /**
     * @return Response
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function postConfirm(): Response
    {
        return $this->render("postConfirm.html.twig");
    }
}
