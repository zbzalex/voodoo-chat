<?php

use Symfony\Component\HttpFoundation\Response;
use VOC\api\Error;

require_once __DIR__ . "/../vendor/autoload.php";

define("ROOT_DIR", dirname(__DIR__));

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
$app->mount("/api", new \VOC\controllerprovider\ApiControllerProvider())
    ->before(
        function (\Symfony\Component\HttpFoundation\Request $request, \Silex\Application $app) {
            if (strtolower(substr($request->getPathInfo(), 0, 4)) === "/api") {
                $apiKey = $request->query->get("api_key");
                $hostHeaders = $request->headers->get('host', null, false);
                $host = $hostHeaders !== null && count($hostHeaders) > 0
                    ? (($pos = strpos($hostHeaders[0], ":")) !== -1
                        ? substr($hostHeaders[0], 0, $pos)
                        : $hostHeaders[0])
                    : null;

                if ($host === null) {
                    return new Response(new Error("Unknown host"));
                }

                $apiUserRepository =
                    new \VOC\repository\ApiUserRepository($app['pdo']->getDao(\VOC\dao\ApiUserDao::class));
                if ($apiKey === null
                    || !\VOC\repository\ApiUserRepository::isValidApiKey($apiKey)
                    || $apiUserRepository->getByApiKeyAndHost($apiKey, $host) == 0) {
                    return new Response(new Error("Access denied"));
                }

                $session = $request->query->get("session");
                if ($session === null) {
                    return new Response(new Error("Unauthorized"));
                }

                $userRepository = new \VOC\repository\UserRepository($app['pdo']->getDao(\VOC\dao\UserDao::class));
                // ...
            }
        }, \Silex\Application::EARLY_EVENT);

$app->run();
