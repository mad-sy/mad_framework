<?php

use App\Core\App;
use App\Providers\AppServiceProvider;
use App\Core\Container;
use League\Container\ReflectionContainer;

require '../vendor/autoload.php';

$container = Container::getInstance();
$container->delegate(new ReflectionContainer());
$container->addServiceProvider(new AppServiceProvider());

var_dump($container->get('name'));
$app = new App();

$app->run();
