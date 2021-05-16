<?php


namespace Chat\util;


use Chat\api\Error;
use Silex\Application;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ErrorHandler
{
    /** @var Application */
    private $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function __invoke(\Exception $e, $code)
    {
        return new JsonResponse(new Error("Unknown error"));
    }
}