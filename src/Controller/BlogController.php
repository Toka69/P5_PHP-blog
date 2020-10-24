<?php

namespace App\Controller;

use Lib\AbstractController;
use App\Model\DBFactory;
use App\Model\PostsManagerPDO;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * BlogController
 */
class BlogController extends AbstractController
{    
    /**
     * test
     *
     * @param  mixed $request
     * @return Response
     */
    public function posts(): Response
    {
        $db = DBFactory::getMysqlConnexionWithPDO();
        $manager = new PostsManagerPDO($db);
        $test = $manager->count();

        return $this->render("posts.html.twig", [
            'nbre_posts' => $test
        ]);
    }
}
