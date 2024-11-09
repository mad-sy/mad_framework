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


class RegisterController
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
            $this->view->render('auth/register.twig', [
                'errors' => $this->session->getFlashBag()->get('errors')[0] ?? null
            ])
        );

        return $response;
    }

    public function store(ServerRequestInterface $request)
    {
        try {
            v::key('first_name', v::alpha()->notEmpty())
                ->key('email', v::email()->notEmpty()->not(v::existsInDatabase('users', 'email')))
                ->key('password', v::notEmpty())
                ->assert($request->getParsedBody());
        } catch (ValidatorException $e) {
            $this->session->getFlashBag()->add('errors', $e->getMessages());
            return new RedirectResponse('/register');
        }

        if ($user = $this->auth->registerAndActivate($request->getParsedBody())) {
            $this->auth->login($user);
        }

        return new RedirectResponse('/dashboard');
    }
}
