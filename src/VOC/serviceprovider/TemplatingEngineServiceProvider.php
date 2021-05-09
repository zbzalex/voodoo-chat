<?php


namespace VOC\serviceprovider;


use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Symfony\Component\Templating\Loader\FilesystemLoader;
use Symfony\Component\Templating\PhpEngine;
use Symfony\Component\Templating\TemplateNameParser;

class TemplatingEngineServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['templating.loader'] = function () use ($app) {
            return new FilesystemLoader($app['templating.paths']);
        };
        $app['templating.template_name_parser'] = function () {
            return new TemplateNameParser();
        };
        $app['templating.engine'] = function () use ($app) {
            return new PhpEngine(
                $app['templating.template_name_parser'],
                $app['templating.loader']
            );
        };
    }
}