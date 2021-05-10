<?php


namespace VOC\dao;


use VOC\db\Dao;
use VOC\vo\Ban;

class BanDao extends Dao
{
    private static $TABLE = "voc2_ban";

    public function getByName($nickname)
    {
        $result = $this->db->executeNativeQuery("SELECT * FROM `" . self::$TABLE . "` WHERE `who`=?;", [
            $nickname
        ]);

        if ($result->rowCount() === 0) {
            return null;
        }

        return Ban::fromState($result->fetch(\PDO::FETCH_ASSOC));
    }
}