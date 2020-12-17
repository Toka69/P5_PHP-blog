<?php


namespace Lib;


class SuperGlobalObject
{
    public $session;
    public $env;
    public $post;
    public $get;

    public function __construct()
    {
        $this->session = $_SESSION;
        $this->env = $_ENV;
    }
}