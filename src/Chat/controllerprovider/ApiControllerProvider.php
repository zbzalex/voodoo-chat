<?php


namespace Chat\controllerprovider;


use Silex\Api\ControllerProviderInterface;
use Silex\Application;
use Silex\ControllerCollection;

class ApiControllerProvider implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        /** @var ControllerCollection $controllers */
        $controllers = $app['controllers_factory'];

        $controllers->get("/getOnlineUsers", '\Chat\controller\ApiController::getOnlineUsers');

        return $controllers;
    }
}