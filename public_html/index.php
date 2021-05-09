<?php

require_once __DIR__ . "/../vendor/autoload.php";

$app = new \Silex\Application();
$app['debug'] = true;

$app['templating.paths'] = dirname(__DIR__) . "/src/VOC/resources/views/%name%";
$app['em.paths'] = [
    dirname(__DIR__) . "/src/VOC/entity"
];
$app['db'] = [
    'driver' => 'pdo_mysql',
    'user' => 'root',
    'password' => '123',
    'dbname' => 'voodoo',
];

$app->register(new \VOC\serviceprovider\TemplatingEngineServiceProvider());
$app->register(new \VOC\serviceprovider\DoctrineOrmServiceProvider());

$app->mount("/", new \VOC\controllerprovider\MainControllerProvider());

$app->run();
