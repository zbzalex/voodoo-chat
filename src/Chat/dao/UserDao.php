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
            "SELECT * FROM `" . UserDao::TABLE . "` WHERE (`last_action`>? OR `bot`=1) AND `room`=?;", [
            \time() - 60 * 60,
            $room
        ]);

        if ($result->rowCount() > 0) {
            /** @var User[] $entities */
            $entities = [];
            while($row = $result->fetch(\PDO::FETCH_ASSOC)) {
                $entities[] = User::fromState($row);
            }

            return $entities;
        }

        return null;
    }
}