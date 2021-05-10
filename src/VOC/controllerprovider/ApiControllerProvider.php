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

        $controllers->get("/getPrivateMessages", '\VOC\controller\ApiController::getPrivateMessages');

        return $controllers;
    }
}