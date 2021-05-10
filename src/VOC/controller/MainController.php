<?php


namespace VOC\controller;


use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use VOC\dao\RoomDao;
use VOC\repository\RoomRepository;

class MainController
{
    public function index(Application $app, Request $request)
    {
        $roomRepository = new RoomRepository($app['pdo']->getDao(RoomDao::class));

        //var_dump($roomRepository->getAll());


        return new Response(
            $app['templating.engine']->render('index.html.php')
        );
    }
}