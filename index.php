<?php

use Illuminate\Http\Request;
use Plast\Laravel\Bootstrap\Laravel;

require __DIR__ . '/vendor/autoload.php';

$laravel = new Laravel(__DIR__ . DIRECTORY_SEPARATOR . 'laravel');
$laravel->application->handleRequest(Request::capture());
