<?php


namespace VOC\dao;


use VOC\db\Dao;
use VOC\vo\Room;

class RoomDao extends Dao
{
    /** @var string table name */
    private static $TABLE = "voc2_rooms";

    public function create(Room $o)
    {
        $result = $this->pdo->executeNativeQuery("INSERT INTO `" . self::TABLE . "` (
            `title`,
            `topic`,
            `bot`,
            `allow_users`,
            `allow_pics`,
            `premoder`,
            `last_action`,
            `clubonly`,
            `password`,
            `jail`,
            `points`
        ) VALUES (
            ?,
            ?,
            ?,
            ?,
            ?,
            ?,
            ?,
            ?,
            ?,
            ?,
            ?
        );", [
            $o->getTitle(),
            $o->getTopic(),
            $o->getBot(),
            $o->getCreator(),
            $o->isAllowedUsers() ? 1 : 0,
            $o->isAllowPics() ? 1 : 0,
            $o->isPremoder() ? 1 : 0,
            $o->getLastAction(),
            $o->isClubOnly() ? 1 : 0,
            $o->getPassword(),
            $o->isJail() ? 1 : 0,
            $o->getPoints()
        ]);

        return $this->db->lastInsertId();
    }

    public function getById($id)
    {
        $result = $this->db->executeNativeQuery("SELECT * FROM `" . self::$TABLE . "` WHERE id=?;", [
            $id
        ]);

        return $result->rowCount() === 0 ? null : Room::fromState($result->fetch(\PDO::FETCH_ASSOC));
    }

    public function getAll()
    {
        $result = $this->db->executeNativeQuery("SELECT * FROM `" . self::$TABLE . "`;");
        $rows = $result->fetchAll(\PDO::FETCH_ASSOC);
        $entities = [];
        for ($i = 0; $i < count($rows); $i++) {
            $entities[] = Room::fromState($rows[$i]);
        }

        return $entities;
    }

    public function getAllDeprecated() {

    }
}