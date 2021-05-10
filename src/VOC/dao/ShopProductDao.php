<?php


namespace VOC\dao;

use VOC\db\IDB;


class ShopProductDao
{
    /** @var IDB */
    private $pdo;

    public function __construct(IDB $pdo)
    {
        $this->pdo = $pdo;
    }
}