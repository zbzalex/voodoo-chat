<?php


namespace Chat\providerhelper;


use Chat\db\DaoRegisry;
use Chat\db\IDB;
use Chat\db\DaoRegistry;


class PDOProviderHelper extends \PDO implements IDB
{
    private $daoRegistry;

    public function __construct($dsn, $username = null, $password = null, $options = null)
    {
        parent::__construct($dsn, $username, $password, $options);

        $this->daoRegistry = new DaoRegistry();
    }

    public function executeNativeQuery($query, array $params = [])
    {
        $st = $this->prepare($query);
        $st->execute($params);

        return $st;
    }

    public function getDao($class)
    {
        if (($dao = $this->daoRegistry->get($class)) != null) {
            return $dao;
        }

        try {
            $reflectionClass = new \ReflectionClass($class);
            if (!$reflectionClass->isAbstract() && !$reflectionClass->isInterface() && !$reflectionClass->isTrait()) {
                // get constructor
                $constructor = $reflectionClass->getConstructor();
                if (!$constructor->isPrivate() && !$constructor->isProtected()) {

                    // create object
                    $object = $reflectionClass->newInstance($this);

                    $this->daoRegistry->set($class, $object);

                    return $object;
                }
            }
        } catch (\ReflectionException $e) {
        }

        return null;
    }
}