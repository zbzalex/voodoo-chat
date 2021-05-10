<?php


namespace VOC\dao;


use VOC\db\IDB;
use VOC\vo\User;

class UserDao
{
    private static $TABLE = "voc2_users";

    /** @var IDB */
    private $db;

    public function __construct(IDB $db)
    {
        $this->db = $db;
    }

    public function getById($id)
    {
        $result = $this->db->executeNativeQuery("SELECT * FROM `" . self::$TABLE . "` WHERE id=?;", [
            $id
        ]);

        return $result->rowCount() === 0 ? null : User::fromState($result->fetch(\PDO::FETCH_ASSOC));
    }
}