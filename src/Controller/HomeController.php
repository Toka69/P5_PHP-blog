<?php

namespace App\Controller;

use Lib\AbstractController;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class HomeController
 * @package App\Controller
 */
 class HomeController extends AbstractController
 {
     /**
      * @return Response
      *
      * @throws \Twig\Error\LoaderError
      * @throws \Twig\Error\RuntimeError
      * @throws \Twig\Error\SyntaxError
      */
       public function home(): Response
       {
            return $this->render("home.html.twig");
       }
 }
 