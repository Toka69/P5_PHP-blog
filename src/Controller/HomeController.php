<?php

namespace App\Controller;

use Lib\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
 
 /**
  * HomeController
  */
 class HomeController extends AbstractController
 {       
       /**
        * home
        *
        * @param  mixed $request
        * @return Response
        */
       public function home(): Response
       {
            return $this->render("home.html.twig", [
                  "prenom" => "Matthias"
            ]);
       }
 }
 