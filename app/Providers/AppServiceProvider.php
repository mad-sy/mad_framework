<?php

namespace App\Providers;

use App\Views\View;
use App\Config\Config;
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
        if ($this->getContainer()->get(Config::class)->get('app.debug')) {
            Ignition::make()->register();
        }

        Factory::setDefaultInstance(
            (new Factory())
                ->withRuleNamespace('App\\Validation\\Rules')
                ->withExceptionNamespace('App\\Validation\Exceptions')
        );

        Paginator::currentPathResolver(function () {
            return strtok($this->getContainer()->get(Request::class)->getUri(), '?');
        });

        Paginator::queryStringResolver(function () {
            return $this->getContainer()->get(Request::class)->getQueryParams();
        });

        Paginator::currentPageResolver(function ($pageName = 'page') {
            return $this->GetContainer()->get(Request::class)->getQueryParams()[$pageName] ?? 1;
        });

        Paginator::viewFactoryResolver(function () {
            return $this->getContainer()->get(View::class);
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
