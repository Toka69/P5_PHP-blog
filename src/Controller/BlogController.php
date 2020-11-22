<?php

namespace App\Controller;

use App\Manager\CommentsManager;
use App\Manager\PostsManager;
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
        $manager = new PostsManager($this->PDOConnection());
        $postsList = $manager->getList();

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
        $postsManager = new PostsManager($this->PDOConnection());
        $singlePost = $postsManager->getSinglePost($_GET['id']);
        $commentsManager = new CommentsManager($this->PDOConnection());
        $comments = $commentsManager->getCommentsPost($_GET['id'], 1);

        return $this->render("post.html.twig",[
            "singlePost" => $singlePost,
            "comments" => $comments
            ]);
    }
}
