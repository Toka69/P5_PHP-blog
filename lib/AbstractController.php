<?php

namespace Lib;

use Twig\Environment;
use Lib\Router\Router;
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

    /**
     * AbstractController constructor.
     * @param Router $router
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * @param string $name
     * @return RedirectResponse
     */
    public function redirect(string $name): RedirectResponse
    {
        return new RedirectResponse($this->router->generate($name));
    }

    /**
     * @param string $view
     * @param array $data
     * @return Response
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function render(string $view, array $data = []): Response
    {
        $loader = new FilesystemLoader(__DIR__ . '/../templates');
        $twig = new Environment($loader, [
            'cache' => false,
        ]);

        return new Response($twig->render($view, $data));
    }
}
