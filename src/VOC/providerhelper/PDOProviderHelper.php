<?php


namespace VOC\providerhelper;


class PDOProviderHelper extends \PDO
{
    public function executeNativeQuery($query, array $params = [])
    {
        $st = $this->prepare($query);
        $st->execute($params);

        return $st;
    }
}