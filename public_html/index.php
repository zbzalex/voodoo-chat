<?php

/**
 * Application entry point
 */

require_once __DIR__ . "/../vendor/autoload.php";

$app = new \Silex\Application();
$app['debug'] = true;

$app['templating.paths'] = dirname(__DIR__) . "/src/VOC/resources/views/%name%";

$app->register(new \VOC\serviceprovider\TemplatingEngineServiceProvider());

$app->mount("/", new \VOC\controllerprovider\MainControllerProvider());

$app->run();
