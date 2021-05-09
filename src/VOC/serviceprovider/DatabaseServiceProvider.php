<?php


namespace VOC\serviceprovider;


use Pimple\Container;
use Pimple\ServiceProviderInterface;
use VOC\providerhelper\PDOProviderHelper;

class DatabaseServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        try {
            $app['pdo'] = new PDOProviderHelper(
                $app['db.config']['driver'] . ":"
                . "host=" . $app['db.config']['host']
                . ";dbname=" . $app['db.config']['dbname'],
                $app['db.config']['user'],
                $app['db.config']['password']
            );
        } catch (\PDOException $e) {
            print($e->getMessage());
        }
    }
}