<?php

require __DIR__ . "/../vendor/autoload.php";

use Lib\Kernel;
use Symfony\Component\Dotenv\Dotenv;

$dotenv = new Dotenv();
$dotenv->load(__DIR__.'/../.env');
$dotenv->load(__DIR__.'/../.env', __DIR__.'/../.env.local');

$kernel = new Kernel();

$response = $kernel->run();

echo $response->getContent();
