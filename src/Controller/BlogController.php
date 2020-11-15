<?php

namespace App\Controller;

use App\Manager\CommentsManager;
use App\Manager\PostsManager;
use Lib\AbstractController;
use Lib\PDOSingleton;
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
        $db = PDOSingleton::getInstance()->getPDO();

        $manager = new PostsManager($db);
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
        $db = PDOSingleton::getInstance()->getPDO();
        $postsManager = new PostsManager($db);
        $singlePost = $postsManager->getSinglePost($_GET['id']);
        $commentsManager = new CommentsManager($db);
        $comments = $commentsManager->getCommentsPost($singlePost[0]['id'], 1);

        return $this->render("post.html.twig",[
            "single_post" => $singlePost,
            "comments" => $comments
            ]);
    }
}
