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
        if (isset($_GET['page']) && !empty($_GET['page']))
        {
            $currentPage = (int) strip_tags($_GET['page']);
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
        $post = $this->exist($_GET["id"], "post");

        if ($post == null)
        {
            return $this->errorResponse(400);
        }

        $singlePost = $this->postsManager->getPost($_GET['id']);
        $comments = $this->commentsManager->getCommentsPost($_GET['id'], 1);
        $disabled = "";
        if (!isset($_SESSION["user"])){
            $disabled = "disabled";
        }

        return $this->render("post.html.twig",[
            "singlePost" => $singlePost,
            "comments" => $comments,
            "disabled" => $disabled
            ]);
    }
}
