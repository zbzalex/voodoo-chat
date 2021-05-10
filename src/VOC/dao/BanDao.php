<?php


namespace VOC\dao;


use VOC\vo\Ban;
use VOC\db\IDB;

class BanDao
{
    private static $TABLE = "voc2_ban";

    /** @var IDB */
    private $pdo;

    public function __construct(IDB $pdo)
    {
        $this->pdo = $pdo;
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