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
        if (!isset($_SESSION["messageHttpResponseCode"]))
        {
            return $this->redirect("home");
        }

        $messageHttpResponseCode = $_SESSION["messageHttpResponseCode"];
        unset ($_SESSION["messageHttpResponseCode"]);

        return $this->render("notFound.html.twig", [
            "httpResponseCode" => http_response_code(),
            "messageHttpResponseCode" => $messageHttpResponseCode
        ]);
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
