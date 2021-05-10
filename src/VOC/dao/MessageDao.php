<?php


namespace VOC\dao;


use VOC\db\IDB;
use VOC\vo\Message;

class MessageDao
{
    private static $TABLE = "voc2_messages";

    /** @var IDB */
    private $db;

    public function __construct(IDB $db)
    {
        $this->db = $db;
    }

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