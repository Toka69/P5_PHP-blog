<?php

require __DIR__ . "/../vendor/autoload.php";

use Lib\Kernel;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\ErrorHandler\Debug;
use Symfony\Component\ErrorHandler\ErrorHandler;
use Symfony\Component\ErrorHandler\DebugClassLoader;

$dotenv = new Dotenv();
$dotenv->load(__DIR__.'/../.env');
$dotenv->load(__DIR__.'/../.env', __DIR__.'/../.env.local');

if ($_ENV["APP_ENV"] === "dev" )
{
    Debug::enable();
    ErrorHandler::register();
    DebugClassLoader::enable();
}

$kernel = new Kernel();

$response = $kernel->run();

echo $response->getContent();
