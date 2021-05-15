<?php


namespace VOC\controllerprovider;


use Silex\Api\ControllerProviderInterface;
use Silex\Application;
use Silex\ControllerCollection;

class ApiControllerProvider implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        /** @var ControllerCollection $controllers */
        $controllers = $app['controllers_factory'];

        $controllers->get("/getUser", "\VOC\controller\ApiController::getUser");
        $controllers->get("/getRoom", "\VOC\controller\ApiController::getRoom");
        $controllers->get("/getRooms", "\VOC\controller\ApiController::getRooms");
        $controllers->get("/getPrivateMessages", '\VOC\controller\ApiController::getPrivateMessages');
        $controllers->get("/who", '\VOC\controller\ApiController::who');
        $controllers->get("/getMessages", '\VOC\controller\ApiController::getMessages');

        return $controllers;
    }
}