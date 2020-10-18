<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

 class HomeController
 {
       public function home(): Response
       {
            return new Response('Page d\'accueil');
       }
 }