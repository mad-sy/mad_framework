<?php

namespace App\Http\Controllers\Auth;

use App\Views\View;
use Laminas\Diactoros\Response;
use Cartalyst\Sentinel\Sentinel;
use Respect\Validation\Validator as v;
use Psr\Http\Message\ServerRequestInterface;
use Laminas\Diactoros\Response\RedirectResponse;
use Respect\Validation\Exceptions\ValidatorException;
use Symfony\Component\HttpFoundation\Session\Session;

class LoginController
{
    public function __construct(
        protected View $view,
        protected Sentinel $auth,
        protected Session $session,
    ) {}

    public function index()
    {
        $response = new Response();

        $response->getBody()->write(
            $this->view->render('auth/login.twig', [
                'errors' => $this->session->getFlashBag()->get('errors')[0] ?? null
            ])
        );

        return $response;
    }

    public function store(ServerRequestInterface $request)
    {
        try {
            v::key('email', v::email()->notEmpty())
                ->key('password', v::notEmpty())
                ->assert($request->getParsedBody());
        } catch (ValidatorException $e) {
            $this->session->getFlashBag()->add('errors', $e->getMessages());
        }

        if (!$this->auth->authenticate($request->getParsedBody())) {

            $this->session->getFlashBag()->add('errors', [
                'email' => 'Could not sign you in with these details'
            ]);

            return new RedirectResponse('/login');
        }

        return new RedirectResponse('/dashboard');
    }
}
