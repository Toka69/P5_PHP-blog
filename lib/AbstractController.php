<?php

namespace Lib;

use App\Manager\CommentsManager;
use App\Manager\PostsManager;
use App\Manager\UsersManager;
use PDO;
use Psr\Log\InvalidArgumentException;
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;
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
    protected CommentsManager $commentsManager;
    protected UsersManager $usersManager;
    protected PostsManager $postsManager;

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

    /**
     * @return PDO
     */
    public function PDOConnection()
    {
        return PDOSingleton::getInstance()->getPDO();
    }

    /**
     * @param $data
     * @return string
     */
    public function testInput($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);

        return $data;
    }

    /**
     * @param $form
     * @return array
     */
    public function secureRequestMethod($form): array
    {
        $data = [];
        foreach($form as $key => $value)
        {
            $data[$key] = $this->testInput($value);
        }

        return $data;
    }

    public function errorResponse ($request, $status)
    {
        if(is_null($request))
        {
            switch ($status)
            {
                case 400 :
                    throw new InvalidArgumentException('400 Bad request');
                    break;
                case 401 :
                    throw new InvalidArgumentException('401 Unauthorized');
                    break;
                case 403 :
                    throw new InvalidArgumentException('403 Forbidden');
                    break;
                case 404 :
                    throw new InvalidArgumentException('404 Not Found');
                    break;
            }
        }
    }

    public function sendEmail ($to, $subject, $body)
    {
        $transport = (new Swift_SmtpTransport($_ENV['MAIL_SMTP'], $_ENV['MAIL_PORT'], $_ENV['MAIL_ENCRYPTION']))
            ->setUsername($_ENV['MAIL_USER'])
            ->setPassword($_ENV['MAIL_PASSWORD']);
        $mailer = new Swift_Mailer($transport);

        $message = (new Swift_Message($subject))
            ->setFrom([$_ENV['MAIL_USER'] => 'Matthias LEROUX'])
            ->setTo($to)
            ->setBody($body);

        $mailer->send($message);
    }

    public function getPostsListPagination($currentPage)
    {
        $nbPosts = $this->postsManager->count();
        $perPage = 5;
        $nbPages = (int)ceil($nbPosts / $perPage);
        $first = ($currentPage * $perPage) - $perPage;
        $posts = $this->postsManager->getListPagination($first, $perPage);

        $array = [
            "nbPages" => $nbPages,
            "posts" => $posts
        ];

        return $array;
    }
}
