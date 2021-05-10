<?php


namespace VOC\repository;


use VOC\dao\UserDao;

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