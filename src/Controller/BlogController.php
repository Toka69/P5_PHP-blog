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
        $count = $manager->count();
        return $this->render("posts.html.twig",[
            "posts_number" => $count
        ]);
    }
}
