<?php


namespace VOC\repository;


use VOC\dao\RoomDao;

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
}