<?php
namespace Lib;

use Twig\Environment;
use Lib\Router\Router;
use Twig\Loader\FilesystemLoader;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

abstract class AbstractController
{
    private Router $router;
    
    /**
     * __construct
     *
     * @param  mixed $router
     * @return void
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }
    
    /**
     * redirect
     *
     * @param  mixed $name
     * @return RedirectResponse
     */
    public function redirect(string $name): RedirectResponse
    {
        return new RedirectResponse($this->router->generate($name));
    }
    
    /**
     * render
     *
     * @param  mixed $view
     * @param  mixed $data
     * @return Response
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