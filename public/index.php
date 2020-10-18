<?php

require __DIR__ . "/../vendor/autoload.php";

use Lib\Kernel;

$kernel = new Kernel();

$response = $kernel->run();

echo $response->getContent();
