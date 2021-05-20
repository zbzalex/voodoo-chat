<?php

use Chat\controllerprovider\ApiControllerProvider;
use Chat\dao\ApiUserDao;
use Chat\repository\ApiUserRepository;
use Chat\repository\UserRepository;
use Chat\serviceprovider\DatabaseServiceProvider;
use Silex\Application;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Chat\api\Error;

require_once __DIR__ . "/../vendor/autoload.php";

define("ROOT_DIR", dirname(__DIR__));

$app = new Application();
$app['debug'] = true;

$app['db.config'] = [
    'driver' => 'mysql',
    'host' => '127.0.0.1',
    'user' => 'root',
    'password' => '123',
    'dbname' => 'voodoo',
];

$app->register(new DatabaseServiceProvider());

$app->mount("/", new ApiControllerProvider());

$app->before(function (Request $request, Application $app) {
    /** @var string $apiKey */
    $apiKey = $request->query->get("api_key");
    /** @var string|null $host */
    $host = $request->headers->get('host', "localhost", true);

    $apiUserRepository =
        new ApiUserRepository($app['pdo']->getDao(ApiUserDao::class));
    if ($apiKey === null
        || !ApiUserRepository::isValidApiKey($apiKey)
        || $apiUserRepository->getByApiKeyAndHost($apiKey, $host) == 0) {
        return new JsonResponse(new Error("Access denied"));
    }

    // Проверяем, чтобы пользователь был авторизован.
    $session = $request->query->get("session");
    if ($session === null) {
        return new JsonResponse(new Error("Unauthorized"));
    }

    //$userRepository = new UserRepository($app['pdo']->getDao(\Chat\dao\UserDao::class));
    // ...

}, Application::EARLY_EVENT);

$app->after(function (Request $request, Response $response) {
    $response->headers->set("Access-Control-Allow-Origin", "*");
});
$app->error(new \Chat\util\ErrorHandler($app));
$app->run();
