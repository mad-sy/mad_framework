<?php

namespace App\Http\Controllers\Auth;

use App\Views\View;
use Laminas\Diactoros\Response;
use Cartalyst\Sentinel\Sentinel;
use Psr\Http\Message\ServerRequestInterface;
use Laminas\Diactoros\Response\RedirectResponse;

class RegisterController
{
    public function __construct(
        protected View $view,
        protected Sentinel $auth,
    ) {}

    public function index()
    {
        $response = new Response();

        $response->getBody()->write(
            $this->view->render('auth/register.twig')
        );

        return $response;
    }

    public function store(ServerRequestInterface $request)
    {
        if ($user = $this->auth->registerAndActivate($request->getParsedBody())) {
            $this->auth->login($user);
        }

        return new RedirectResponse('/dashboard');
    }
}
