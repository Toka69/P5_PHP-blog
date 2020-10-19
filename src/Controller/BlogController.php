<?php
namespace App\Controller;

use Lib\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BlogController extends AbstractController
{
    public function test(Request $request): Response
    {
        return $this->redirect("home");
    }
}