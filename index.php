<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/vendor/autoload.php';

Application::configure(__DIR__ . DIRECTORY_SEPARATOR . 'laravel')
    ->withRouting(function (): void {
        Route::get('/', fn() => view('index', ['phpVersion' => \PHP_VERSION]));
    })
    ->create()
    ->handleRequest(Request::capture());
