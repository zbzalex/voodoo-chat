<?php


namespace Chat\dao;


use Chat\db\Dao;
use Chat\vo\Message;

class MessageDao extends Dao
{
    const TABLE = "messages";

    /**
     * @param int $room
     */
    public function getMessagesByRoom($room)
    {

    }
}