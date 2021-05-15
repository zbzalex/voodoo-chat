<?php


namespace Chat\dao;


use Chat\db\Dao;
use Chat\vo\Room;

class RoomDao extends Dao
{
    const TABLE = "rooms";

    public function create(Room $o)
    {
        $result = $this->pdo->executeNativeQuery("INSERT INTO `" . RoomDao::TABLE . "` (
            `title`,
            `topic`,
            `bot`,
            `allow_users`,
            `last_action`,
            `password`,
            `jail`,
            `points`,
            `created_at`,
            `updated_at`
        ) VALUES (
            ?,
            ?,
            ?,
            ?,
            0,
            ?,
            ?,
            ?,
            UNIX_TIMESTAMP(),
            UNIX_TIMESTAMP()
        );", [
            $o->getTitle(),
            $o->getTopic(),
            $o->getBot(),
            $o->getCreator(),
            $o->isAllowedUsers() ? 1 : 0,
            $o->getPassword(),
            $o->isJail() ? 1 : 0,
            $o->getPoints()
        ]);

        return $this->db->lastInsertId();
    }

    public function getById($id)
    {
        $result = $this->db->executeNativeQuery("SELECT * FROM `" . RoomDao::TABLE . "` WHERE `id`=?;", [
            $id
        ]);

        return $result->rowCount() === 0 ? null : Room::fromState($result->fetch(\PDO::FETCH_ASSOC));
    }

    public function getAll()
    {
        $result = $this->db->executeNativeQuery("SELECT * FROM `" . RoomDao::TABLE . "`;");
        $rows = $result->fetchAll(\PDO::FETCH_ASSOC);
        $entities = [];
        for ($i = 0; $i < count($rows); $i++) {
            $entities[] = Room::fromState($rows[$i]);
        }

        return $entities;
    }
}