<?php


namespace VOC\dao;


use VOC\providerhelper\PDOProviderHelper;
use VOC\vo\Ban;

class BanDao
{
    private static $TABLE = "voc2_ban";
    private $pdo;

    public function __construct(PDOProviderHelper $pdo)
    {

    }

    public function findByName($name)
    {
        $result = $this->pdo->executeNativeQuery("SELECT * FROM `" . self::$TABLE . "` WHERE `who`=?;", [
            $name
        ]);

        if ($result->rowCount() === 0) {
            return null;
        }

        return Ban::fromState($result->fetch(\PDO::FETCH_ASSOC));
    }
}