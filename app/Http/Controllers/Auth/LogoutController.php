<?php

namespace App\Http\Controllers\Auth;

use Laminas\Diactoros\Response;
use Cartalyst\Sentinel\Sentinel;
use Psr\Http\Message\ServerRequestInterface;
use Laminas\Diactoros\Response\RedirectResponse;

class LogoutController
{
    public function __construct(
        protected Sentinel $auth,
    ) {}

    public function __invoke(ServerRequestInterface $request)
    {
        $this->auth->logout();

        return new RedirectResponse('/');
    }
}
