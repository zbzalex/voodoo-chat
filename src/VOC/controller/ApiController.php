<?php


namespace VOC\controller;


use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use VOC\api\Error;
use VOC\api\Ok;

class ApiController
{
    public function getPrivateMessages(Application $app, Request $request)
    {
        $session = $request->query->get("session");
        if ($session === null) {
            return new Response(new Error("Unauthorized"));
        }

        return new Response(new Ok());
    }
}