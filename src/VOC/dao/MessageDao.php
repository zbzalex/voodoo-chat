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

    public function getMessagesByRoomDeprecated($room, $offset, $limit)
    {
        $rows = @file(ROOT_DIR . "/data/messages.dat");
        if ($rows !== false && count($rows) > 0) {
            $entities = [];
            for ($i = 0; $i < count($rows); $i++) {

                $row = \explode("\t", $rows[$i]);

                if (intval($row[1]) != $room) continue;

                $entities[] = new Message(
                    intval($row[0]),
                    intval($row[1]),
                    intval($row[2]),
                    $row[3],
                    $row[4],
                    $row[5],
                    intval($row[6]),
                    $row[7],
                    $row[8],
                    $row[9],
                    intval($row[10]),
                    $row[11],
                    intval($row[12])
                );
            }

            return array_slice($entities, $offset, $limit);
        }

        return null;
    }
}