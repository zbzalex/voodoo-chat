<?php

require_once __DIR__ . "/../vendor/autoload.php";

$app = new \Silex\Application();
$app['debug'] = true;

$app['templating.paths'] = dirname(__DIR__) . "/src/VOC/resources/views/%name%";

$app['db.config'] = [
    'driver' => 'mysql',
    'host' => '127.0.0.1',
    'user' => 'root',
    'password' => '123',
    'dbname' => 'voodoo',
];

$app->register(new \VOC\serviceprovider\TemplatingEngineServiceProvider());
$app->register(new \VOC\serviceprovider\DatabaseServiceProvider());

$app->mount("/", new \VOC\controllerprovider\MainControllerProvider());
$app->mount("/api", new \VOC\controllerprovider\ApiControllerProvider());

$app->run();
