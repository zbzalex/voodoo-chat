<?php


namespace VOC\dao;


use VOC\db\Dao;
use VOC\vo\Ban;

class BanDao extends Dao
{
    private static $TABLE = "voc2_ban";

    /** @deprecated */
    public function getByNicknameDeprecated($nickname)
    {
        $rows = @file(ROOT_DIR . "/data/banlist.dat");
        if ($rows !== false && count($rows) > 0) {
            for ($i = 0; $i < count($rows); $i++) {
                $row = explode("\t", $rows[$i]);
                return new Ban(0, $row[0], $row[1], $row[2], $row[3]);
            }
        }

        return null;
    }

    public function getByNickname($nickname)
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