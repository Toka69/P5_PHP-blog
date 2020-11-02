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
}
