<?php


namespace Chat\db;

interface IDB
{
    public function executeNativeQuery($query, array $params = []);

    public function getDao($class);
}