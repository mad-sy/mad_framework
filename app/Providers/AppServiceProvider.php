<?php

namespace App\Providers;

use App\Config\Config;
use Spatie\Ignition\Ignition;
use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Container\ServiceProvider\BootableServiceProviderInterface;

class AppServiceProvider extends AbstractServiceProvider implements BootableServiceProviderInterface
{
    public function boot(): void
    {
        if ($this->getContainer()->get(Config::class)->get('app.debug')) {
            Ignition::make()->register();
        }
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
