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

    public function getById($id)
    {
        return $this->userDao->getById($id);
    }
}