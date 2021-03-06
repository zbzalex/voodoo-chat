<?php


namespace Chat\repository;


use Chat\dao\MessageDao;

class MessageRepository
{
    /** @var MessageDao */
    private $messageDao;

    public function __construct(MessageDao $messageDao)
    {
        $this->messageDao = $messageDao;
    }

    public function getPrivateMessages($userId)
    {
        return $this->messageDao->getPrivateMessages($userId);
    }

    public function getMessagesByRoom($room, $offset, $limit)
    {
        return $this->messageDao->getMessagesByRoomDeprecated($room, $offset, $limit);
    }
}