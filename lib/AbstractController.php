<?php
namespace Lib;

use Twig\Environment;
use Lib\Router\Router;
use Twig\Loader\FilesystemLoader;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

abstract class AbstractController
{
    private Router $_router;

    public function __construct(Router $router)
    {
        $this->_router = $router;
    }

    public function redirect(string $name): RedirectResponse
    {
        return new RedirectResponse($this->_router->generate($name));
    }

    public function render(string $view, array $data = []): Response
    {
        $loader = new FilesystemLoader(__DIR__ . '/../templates');
        $twig = new Environment($loader, [
        'cache' => false,
        ]);

        return new Response($twig->render($view, $data));
    }
}