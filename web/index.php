<?php

use App\Infra\Symfony\Kernel;

require __DIR__.'/../vendor/autoload.php';

$env   = getenv('SYMFONY_ENV') ?: 'prod';
$debug = (bool)getenv('SYMFONY_DEBUG') ?: $env !== 'prod';

(new Kernel($env, $debug))->__invoke();
