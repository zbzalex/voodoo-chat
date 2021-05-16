<?php


namespace Chat\dao;


use Chat\db\Dao;
use Chat\vo\User;

class UserDao extends Dao
{
    const TABLE = "users";

    public function getById($id)
    {
        $result = $this->db->executeNativeQuery("SELECT * FROM `" . UserDao::TABLE . "` WHERE `id`=?;", [
            $id
        ]);

        return $result->rowCount() === 0 ? null : User::fromState($result->fetch(\PDO::FETCH_ASSOC));
    }

    public function getOnlineUsersByRoom($room)
    {
        /** @var \PDOStatement $result */
        $result = $this->db->executeNativeQuery(
            "SELECT * FROM `" . UserDao::TABLE . "` WHERE `last_action`>? AND `room`=?;", [
            \time() - 60 * 5,
            $room
        ]);

        if ($result->rowCount() > 0) {
            /** @var User[] $entities */
            $entities = [];

            for ($i = 0; $i < $result->rowCount(); $i++) {
                $entities[] = User::fromState($result->fetch());
            }

            return $entities;
        }

        return null;
    }
}