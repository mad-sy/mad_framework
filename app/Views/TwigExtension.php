<?php

namespace App\Views;

use Twig\TwigFunction;
use Twig\Extension\AbstractExtension;

class TwigExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('config', [TwigRuntimeExtension::class, 'config']),
            new TwigFunction('auth', [TwigRuntimeExtension::class, 'auth']),
            new TwigFunction('csrf', [TwigRuntimeExtension::class, 'csrf']),
        ];
    }
}
