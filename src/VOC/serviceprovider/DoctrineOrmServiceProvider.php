<?php


namespace VOC\serviceprovider;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Tools\Setup;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class DoctrineOrmServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $config = Setup::createAnnotationMetadataConfiguration($app['em.paths'], $app['debug']);

        try {
            $entityManager = EntityManager::create($app['db'], $config);
            $app['em'] = $entityManager;
        } catch (ORMException $e) {

        }

    }
}