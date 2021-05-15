<?php


namespace VOC\dao;


use VOC\db\Dao;
use VOC\vo\User;

class UserDao extends Dao
{
    private static $TABLE = "voc2_users";

    public function getById($id)
    {
        $result = $this->db->executeNativeQuery("SELECT * FROM `" . self::$TABLE . "` WHERE id=?;", [
            $id
        ]);

        return $result->rowCount() === 0 ? null : User::fromState($result->fetch(\PDO::FETCH_ASSOC));
    }
}