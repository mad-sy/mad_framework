<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\FlashOldDataMiddleware;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Middleware\RedirectIfGuest;
use League\Route\RouteGroup;
use League\Route\Router;
use Psr\Container\ContainerInterface;

return static function (Router $router, ContainerInterface $container) {
    $router->middleware($container->get('csrf'));
    $router->middleware(new FlashOldDataMiddleware);

    $router->get('/', HomeController::class)->setName('home');
    $router->get('/dashboard', DashboardController::class)->middleware(new RedirectIfGuest())->setName('dashboard');

    $router->get('/users/{user}', UserController::class)->setName('users.show');


    $router->post('/logout', LogoutController::class)->setName('logout');

    $router->group('/', function (RouteGroup $route) {
        $route->get('/register', [RegisterController::class, 'index'])->setName('register.index');
        $route->post('/register', [RegisterController::class, 'store'])->setName('register.store');
        $route->get('/login', [LoginController::class, 'index'])->setName('login.index');
        $route->post('/login', [LoginController::class, 'store'])->setName('login.store');
    })->middleware(new RedirectIfAuthenticated());
};
