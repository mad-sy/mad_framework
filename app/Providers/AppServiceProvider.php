<?php

namespace App\Providers;

use App\Views\View;
use Spatie\Ignition\Ignition;
use Laminas\Diactoros\Request;
use Respect\Validation\Factory;
use Illuminate\Pagination\Paginator;
use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Container\ServiceProvider\BootableServiceProviderInterface;

class AppServiceProvider extends AbstractServiceProvider implements BootableServiceProviderInterface
{
    public function boot(): void
    {
        if (config('app.debug')) {
            Ignition::make()->register();
        }

        Factory::setDefaultInstance(
            (new Factory())
                ->withRuleNamespace('App\\Validation\\Rules')
                ->withExceptionNamespace('App\\Validation\Exceptions')
        );

        Paginator::currentPathResolver(function () {
            return strtok(app(Request::class)->getUri(), '?');
        });

        Paginator::queryStringResolver(function () {
            return app(Request::class)->getQueryParams();
        });

        Paginator::currentPageResolver(function ($pageName = 'page') {
            return app(Request::class)->getQueryParams()[$pageName] ?? 1;
        });

        Paginator::viewFactoryResolver(function () {
            return app(View::class);
        });

        Paginator::defaultView('pagination/default.twig');
    }

    public function register(): void
    {
        $this->getContainer()->add('name', function () {
            return 'my name';
        });
    }

    public function provides(string $id): bool
    {
        $services = [
            'name',
        ];

        return in_array($id, $services);
    }
}
