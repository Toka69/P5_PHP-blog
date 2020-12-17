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
    *
    * @throws LoaderError
    * @throws RuntimeError
    * @throws SyntaxError
    */
    public function notFound(): Response
    {
        if (!isset($this->superGlobalObject->session["messageHttpResponseCode"]))
        {
            return $this->errorResponse(400);
        }

        $messageHttpResponseCode = $this->superGlobalObject->session["messageHttpResponseCode"];
        unset ($this->superGlobalObject->session["messageHttpResponseCode"]);

        return $this->render("notFound.html.twig", [
            "httpResponseCode" => http_response_code(),
            "messageHttpResponseCode" => $messageHttpResponseCode
        ]);
    }

    public function contact(): Response
    {
        if($_SERVER["REQUEST_METHOD"] === "POST")
        {
         $this->sendEmail($_ENV['MAIL_NOTIFICATION'], 'Nouvelle demande de contact depuis le site',

'Demande de '.$this->superGlobalObject->post['name'].'
             
'.$this->superGlobalObject->post['message'].'

'.$this->superGlobalObject->post['email'].'            
            
            ');
        }

        return $this->redirect("home");
    }
}
