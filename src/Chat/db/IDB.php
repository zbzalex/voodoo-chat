<?php


namespace VOC\db;

interface IDB
{
    public function executeNativeQuery($query, array $params = []);

    public function getDao($class);
}