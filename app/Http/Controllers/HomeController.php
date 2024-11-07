<?php

namespace App\Http\Controllers;

use App\Views\View;
use App\Config\Config;
use Laminas\Diactoros\Response;
use Psr\Http\Message\ServerRequestInterface;

class HomeController
{
    public function __construct(
        protected Config $config,
        protected View $view
    ) {}

    public function __invoke(ServerRequestInterface $request)
    {
        $response = new Response();

        $response->getBody()->write(
            $this->view->render('home.twig', [
                'name' => $this->config->get('app.name'),
                'users' => [
                    ['id' => 1, 'name' => 'Mohamad'],
                    ['id' => 2, 'name' => 'Alex'],
                ]
            ])
        );

        return $response;
    }
}
