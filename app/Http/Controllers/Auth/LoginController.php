<?php

namespace App\Http\Controllers\Auth;

use App\Views\View;
use Laminas\Diactoros\Response;
use Cartalyst\Sentinel\Sentinel;
use Psr\Http\Message\ServerRequestInterface;
use Laminas\Diactoros\Response\RedirectResponse;

class LoginController
{
    public function __construct(
        protected View $view,
        protected Sentinel $auth,
    ) {}

    public function index()
    {
        $response = new Response();

        $response->getBody()->write(
            $this->view->render('auth/login.twig')
        );

        return $response;
    }

    public function store(ServerRequestInterface $request)
    {
        if (!$this->auth->authenticate($request->getParsedBody())) {
            return new RedirectResponse('/login');
        }

        return new RedirectResponse('/dashboard');
    }
}
