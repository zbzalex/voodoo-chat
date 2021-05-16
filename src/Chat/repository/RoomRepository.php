<?php


namespace Chat\repository;


use Chat\dao\RoomDao;

class RoomRepository
{
    private $roomDao;

    public function __construct(RoomDao $roomDao)
    {
        $this->roomDao = $roomDao;
    }

    public function getAll()
    {
        return $this->roomDao->getAll();
    }

    public function getRoomById($id)
    {
        return $this->roomDao->getById($id);
    }
}