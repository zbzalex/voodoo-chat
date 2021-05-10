<?php


namespace VOC\dao;


use VOC\db\IDB;

class WhoDao
{
    private $db;

    public function __construct(IDB $db)
    {
        $this->db = $db;
    }
}