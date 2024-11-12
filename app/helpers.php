<?php

use App\Views\View;
use App\Config\Config;
use App\Core\Container;
use Laminas\Diactoros\Response;

function app(string $abstract)
{
    return Container::getInstance()->get($abstract);
}

function view(string $view, array $data = [])
{
    $response = new Response();

    $response->getBody()->write(
        app(View::class)->render($view, $data)
    );

    return $response;
}

function config(string $key, $default = null)
{
    return app(Config::class)->get($key, $default);
}
