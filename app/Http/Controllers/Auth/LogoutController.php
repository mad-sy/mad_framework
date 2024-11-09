<?php

namespace App\Http\Controllers\Auth;

use Cartalyst\Sentinel\Sentinel;
use Psr\Http\Message\ServerRequestInterface;
use Laminas\Diactoros\Response\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Session;

class LogoutController
{
    public function __construct(
        protected Sentinel $auth,
        protected Session $session,
    ) {}

    public function __invoke(ServerRequestInterface $request)
    {
        $this->auth->logout();

        $this->session->getFlashBag()->add('message', 'You have logged out!');

        return new RedirectResponse('/');
    }
}
