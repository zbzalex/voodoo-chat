<?php


namespace VOC\repository;


use VOC\dao\MessageDao;

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
}