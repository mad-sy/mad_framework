<?php

namespace App\Core;

use App\Exceptions\ExceptionHandler;
use League\Route\Router;
use Laminas\Diactoros\Request;
use Laminas\Diactoros\Response;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;

class App
{
    protected ServerRequestInterface $request;
    protected Router $router;

    public function __construct(protected ContainerInterface $container)
    {
        $this->request = $this->container->get(Request::class);
        $this->router = $this->container->get(Router::class);
    }

    public function getRouter(): Router
    {
        return $this->router;
    }

    public function run()
    {
        $response = new Response();
        try {
            $response = $this->router->dispatch($this->request);
        } catch (\Throwable $e) {
            $this->container->get(ExceptionHandler::class)->handle($this->request, $response, $e);
            // throw $e;
        }

        (new SapiEmitter())->emit($response);
    }
}
