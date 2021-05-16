<?php


namespace Chat\repository;


use Chat\dao\UserDao;

class UserRepository
{
    private $userDao;

    public function __construct(UserDao $userDao)
    {
        $this->userDao = $userDao;
    }

    /**
     * @param int $id
     * @return \Chat\vo\User|null
     */
    public function getRoomById($id)
    {
        return $this->userDao->getById($id);
    }

    /**
     * @param int $room
     * @return \Chat\vo\User[]|null
     */
    public function getOnlineUsersByRoom($room)
    {
        return $this->userDao->getOnlineUsersByRoom($room);
    }
}