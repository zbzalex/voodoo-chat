<?php


namespace VOC\controller;


use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MainController
{
    public function index(Application $app, Request $request)
    {
        return new Response(
            $app['templating.engine']->render('index.html.php')
        );
    }

    public function signOut(Application $app, Request $request)
    {

    }

    public function signUp(Application $app, Request $request)
    {
        /** @var string $username */
        $username = $request->request->get("username");
        /** @var int $sex */
        $sex = $request->request->get("sex");

        $refId = $request->query->get("ref_id");

        return new Response(
            $app['templating.engine']->render('signUp.html.php')
        );
    }

    public function profile(Application $app, Request $request)
    {

    }
}