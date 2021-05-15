<?php

use Symfony\Component\HttpFoundation\Response;
use VOC\api\Error;

require_once __DIR__ . "/../vendor/autoload.php";

define("ROOT_DIR", dirname(__DIR__));

$app = new \Silex\Application();
$app['debug'] = true;

$app['db.config'] = [
    'driver' => 'mysql',
    'host' => '127.0.0.1',
    'user' => 'root',
    'password' => '123',
    'dbname' => 'voodoo',
];

$app->register(new \VOC\serviceprovider\DatabaseServiceProvider());

$app->mount("/api", new \VOC\controllerprovider\ApiControllerProvider());

$app->before(function (\Symfony\Component\HttpFoundation\Request $request, \Silex\Application $app) {
        if (strtolower(substr($request->getPathInfo(), 0, 4)) === "/api") {
            $apiKey = $request->query->get("api_key");
            $host = $request->headers->get('host', "localhost", true);
            $apiUserRepository =
                new \VOC\repository\ApiUserRepository($app['pdo']->getDao(\VOC\dao\ApiUserDao::class));
            if ($apiKey === null
                || !\VOC\repository\ApiUserRepository::isValidApiKey($apiKey)
                || $apiUserRepository->getByApiKeyAndHost($apiKey, $host) == 0) {
                return new Response(new Error("Access denied"));
            }

            // Проверяем, чтобы пользователь был авторизован.
            $session = $request->query->get("session");
            if ($session === null) {
                return new Response(new Error("Unauthorized"));
            }

            $userRepository = new \VOC\repository\UserRepository($app['pdo']->getDao(\VOC\dao\UserDao::class));
            // ...
        }
    }, \Silex\Application::EARLY_EVENT);

$app->after(function (\Symfony\Component\HttpFoundation\Request $request, Response $response) {
    $response->headers->set("Access-Control-Allow-Origin", "*");
});
$app->error(new \VOC\util\ErrorHandler($app));
$app->run();
