<?php

namespace App\Http\Controllers;

use App\Views\View;
use App\Config\Config;
use Laminas\Diactoros\Response;

class DashboardController
{
    public function __construct(
        protected Config $config,
        protected View $view
    ) {}

    public function __invoke()
    {
        $response = new Response();

        $response->getBody()->write(
            $this->view->render('dashboard.twig')
        );

        return $response;
    }
}
