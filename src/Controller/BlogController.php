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
        $postsList = $this->postsManager->getList();

        return $this->render("posts.html.twig",[
            "postsList" => $postsList
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
        $singlePost = $this->postsManager->getSinglePost($_GET['id']);
        $comments = $this->commentsManager->getCommentsPost($_GET['id'], 1);

        return $this->render("post.html.twig",[
            "singlePost" => $singlePost,
            "comments" => $comments
            ]);
    }
}
