<?php

namespace App\Controller;

use App\PostsManager;
use Lib\AbstractController;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class BlogController
 * @package App\Controller
 */
class BlogController extends AbstractController
{
    /**
     * @return Response
     *
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function posts(): Response
    {
        $manager = new PostsManager();
        $postsList = $manager->getList($begin=0, $end=4);

        return $this->render("posts.html.twig",[
            "posts_list" => $postsList
        ]);
    }

    public function post(): Response
    {
        $manager = new PostsManager();
        $singlePost = $manager->getSinglePost($_GET['id']);
        $comments = $manager->getCommentsPost($singlePost[0]['id'], 1);

        return $this->render("post.html.twig",[
            "single_post" => $singlePost,
            "comments" => $comments
            ]);
    }
}
