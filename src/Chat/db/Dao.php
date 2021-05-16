<?php


namespace Chat\db;


abstract class Dao
{
    protected $db;
    public function __construct(IDB $db) {
        $this->db = $db;
    }
}