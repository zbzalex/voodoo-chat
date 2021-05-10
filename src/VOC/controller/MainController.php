<?php


namespace VOC\controller;


use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use VOC\dao\RoomDao;
use VOC\dao\WhoDao;
use VOC\repository\RoomRepository;
use VOC\repository\WhoRepository;

class MainController
{
    public function index(Application $app, Request $request)
    {
        $whoRepository = new WhoRepository($app['pdo']->getDao(WhoDao::class));

        return new Response(
            $app['templating.engine']->render('index.html.php', [
                'who' => $whoRepository->getAll()
            ])
        );
    }
}