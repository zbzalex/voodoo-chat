<?php


namespace VOC\util;


use Silex\Application;
use Symfony\Component\HttpFoundation\RedirectResponse;
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
        return new Response($this->app['templating.engine']->render('not_found.html.php', [
            'code' => $code,
            'message' => $e->getMessage()
        ]));
    }
}