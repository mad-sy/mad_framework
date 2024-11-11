<?php

namespace App\Providers;

use App\Validation\Exceptions\CsrfTokenException;
use Laminas\Diactoros\ResponseFactory;
use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Container\ServiceProvider\BootableServiceProviderInterface;
use Slim\Csrf\Guard;

class CsrfServiceProvider extends AbstractServiceProvider implements BootableServiceProviderInterface
{
    public function boot(): void {}

    public function register(): void
    {
        $this->getContainer()->add('csrf', function () {
            $guard = new Guard(new ResponseFactory());

            $guard->setFailureHandler(function () {
                throw new CsrfTokenException();
            });
            
            return $guard;
        })->setShared();
    }

    public function provides(string $id): bool
    {
        $services = [
            'csrf',
        ];

        return in_array($id, $services);
    }
}
