<?php


namespace VOC\dao;


use VOC\db\Dao;
use VOC\vo\Message;

class MessageDao extends Dao
{
    private static $TABLE = "voc2_messages";

    public function getPrivateMessages($userId)
    {
        $result = $this->db->executeNativeQuery("SELECT * FROM `" . self::$TABLE . "` WHERE user_id=?", [
            $userId
        ]);

        if ($result->rowCount() > 0) {
            $rows = $result->fetchAll(\PDO::FETCH_ASSOC);
            $entities = [];
            for ($i = 0; $i < $result->rowCount(); $i++) {
                $entities[] = Message::fromState($rows[$i]);
            }
        }

        return null;
    }
}