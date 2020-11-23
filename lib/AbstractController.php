<?php

namespace Lib;

use App\Manager\CommentsManager;
use App\Manager\PostsManager;
use App\Manager\UsersManager;
use Twig\Environment;
use Lib\Router\Router;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Class AbstractController
 * @package Lib
 */
abstract class AbstractController
{
    private Router $router;
    protected $commentsManager;
    protected $usersManager;
    protected $postsManager;

    /**
     * @param Router $router
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
        $this->commentsManager = new CommentsManager();
        $this->usersManager = new UsersManager();
        $this->postsManager = new PostsManager();
    }

    /**
     * @param string $name
     *
     * @return RedirectResponse
     */
    public function redirect(string $name): RedirectResponse
    {
        return new RedirectResponse($this->router->generate($name));
    }

    /**
     * @param string $view
     * @param array $data
     *
     * @return Response
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function render(string $view, array $data = []): Response
    {
        $loader = new FilesystemLoader(__DIR__ . '/../templates');
        $twig = new Environment($loader, [
            'cache' => false,
            'debug' => true
        ]);
        $twig->addExtension(new DebugExtension());
        $twig->addGlobal('session', $_SESSION);

        return new Response($twig->render($view, $data));
    }

    public function PDOConnection()
    {
        return PDOSingleton::getInstance()->getPDO();
    }

    public function testInput($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);

        return $data;
    }

    public function secureForm($form): array
    {
        $data = [];
        foreach($form as $key => $value)
        {
            $data[$key] = $this->testInput($value);
        }

        return $data;
    }
}
