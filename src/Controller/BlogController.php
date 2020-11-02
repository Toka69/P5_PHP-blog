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
        foreach ($postsList as $posts){
            $array = [
                    'title' => $posts['title'],
                    'leadParagraph'  => $posts['lead_paragraph'],
                    'content' => $posts['content'],
                    'creatingDate' => $posts['creating_date'],
                    'modifiedDate' => $posts['modified_date']
                ];
            $tab[]= $array;
        }

        return $this->render("posts.html.twig",[
            "posts_list" => $tab
        ]);
    }
}
