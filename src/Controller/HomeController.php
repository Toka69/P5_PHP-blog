<?php

namespace App\Controller;

use Lib\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class HomeController
 * @package App\Controller
 */
class HomeController extends AbstractController
{
    /**
    * @return Response
    *
    * @throws LoaderError
    * @throws RuntimeError
    * @throws SyntaxError
    */
    public function home(): Response
    {
        return $this->render("home.html.twig");
    }

    /**
    * @return Response
    */
    public function urlError(): Response
    {
        return $this->redirect("notFound");
    }

    /**
    * @return Response
    *
    * @throws LoaderError
    * @throws RuntimeError
    * @throws SyntaxError
    */
    public function notFound(): Response
    {
        return $this->render("404.html.twig");
    }

    public function contact(){
        if($_SERVER["REQUEST_METHOD"] === "POST")
        {
         $secureRequestMethod = $this->secureRequestMethod($_POST);
         $this->sendEmail($_ENV['MAIL_NOTIFICATION'], 'Nouvelle demande de contact depuis le site',

'Demande de '.$secureRequestMethod['name'].'
             
'.$secureRequestMethod['message'].'

'.$secureRequestMethod['email'].'            
            
            ');
        }

        return $this->redirect("home");
    }
}
