<?php

namespace App\Controller;

use App\CommentsManager;
use App\PostsManager;
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
        $manager = new PostsManager();
        $postsList = $manager->getList(0,10);

        return $this->render("posts.html.twig",[
            "posts_list" => $postsList
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
        $postsManager = new PostsManager();
        $singlePost = $postsManager->getSinglePost($_GET['id']);
        $commentsManager = new CommentsManager();
        $comments = $commentsManager->getCommentsPost($singlePost[0]['id'], 1);

        return $this->render("post.html.twig",[
            "single_post" => $singlePost,
            "comments" => $comments
            ]);
    }
}
