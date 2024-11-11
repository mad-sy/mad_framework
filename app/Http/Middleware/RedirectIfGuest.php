<?php

namespace App\Http\Middleware;

use App\Core\Container;
use Cartalyst\Sentinel\Sentinel;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Laminas\Diactoros\Response\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Session;

class RedirectIfGuest implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $container = Container::getInstance();

        if (!$container->get(Sentinel::class)->check()) {
            $container->get(Session::class)->getFlashBag()->add('message', 'Login before!');
            return new RedirectResponse('/login');
        }

         return $handler->handle($request);
    }
}
