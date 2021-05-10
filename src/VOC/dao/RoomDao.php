<?php


namespace VOC\dao;


use VOC\vo\Room;
use VOC\db\IDB;

class RoomDao
{
    private static $TABLE = "voc2_rooms";

    /** @var IDB */
    private $pdo;

    public function __construct(IDB $pdo)
    {
        $this->pdo = $pdo;
    }

    public function create(Room $o)
    {
        $result = $this->pdo->executeNativeQuery("INSERT INTO `" . self::TABLE . "` (
            `title`,
            `topic`,
            `bot`,
            `jail`,
            `points`
        ) VALUES (
            ?,
            ?,
            ?,
            ?,
            ?
        );", [
            $o->getTitle(),
            $o->getTopic(),
            $o->getBot(),
            $o->isJail() ? 1 : 0,
            $o->getPoints()
        ]);

        return $this->pdo->lastInsertId();
    }

    public function getById($id)
    {
        $result = $this->pdo->executeNativeQuery("SELECT * FROM `" . self::$TABLE . "` WHERE id=?;", [
            $id
        ]);

        return $result->rowCount() === 0 ? null : Room::fromState($result->fetch(\PDO::FETCH_ASSOC));
    }

    public function getAll()
    {
        $result = $this->pdo->executeNativeQuery("SELECT * FROM `" . self::$TABLE . "`;");
        $rows = $result->fetchAll(\PDO::FETCH_ASSOC);
        $entities = [];
        for ($i = 0; $i < count($rows); $i++) {
            $entities[] = Room::fromState($rows[$i]);
        }

        return $entities;
    }
}