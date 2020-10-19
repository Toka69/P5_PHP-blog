<?php
namespace Lib;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractController
{
    public function render(string $view, array $data = []): Response
    {
        $loader = new FilesystemLoader(__DIR__ . '/../templates');
        $twig = new Environment($loader, [
        'cache' => false,
        ]);

        return new Response($twig->render($view, $data));
    }
}