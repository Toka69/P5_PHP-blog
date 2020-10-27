<?php

namespace App\Controller;

use Lib\AbstractController;
use App\Model\DBFactory;
use App\Model\PostsManagerPDO;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class BlogController
 * @package App\Controller
 */
class BlogController extends AbstractController
{
    /**
     * @return Response
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function posts(): Response
    {
        $db = DBFactory::getMysqlConnexionWithPDO();
        $manager = new PostsManagerPDO($db);
        $test = $manager->count();

        return $this->render("posts.html.twig", [
            'number_posts' => $test
        ]);
    }
}
