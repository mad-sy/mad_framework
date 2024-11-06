<?php

namespace App\Providers;

use Spatie\Ignition\Ignition;
use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Container\ServiceProvider\BootableServiceProviderInterface;

class AppServiceProvider extends AbstractServiceProvider implements BootableServiceProviderInterface
{
    public function boot(): void
    {
        Ignition::make()->register();
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
