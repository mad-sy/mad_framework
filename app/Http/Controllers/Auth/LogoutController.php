<?php

namespace App\Http\Controllers\Auth;

use Cartalyst\Sentinel\Sentinel;
use Laminas\Diactoros\Response\RedirectResponse;

class LogoutController
{
    public function __construct(
        protected Sentinel $auth,
    ) {}

    public function __invoke()
    {
        $this->auth->logout();
        return new RedirectResponse('/');
    }
}
