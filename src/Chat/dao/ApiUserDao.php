<?php


namespace Chat\dao;


use Chat\db\Dao;

class ApiUserDao extends Dao
{
    const TABLE = "api_users";

    public function getByApiKeyAndHost($apiKey, $host)
    {
        $result = $this->db->executeNativeQuery(
            "SELECT * FROM `" . static::TABLE . "` WHERE `api_key`=? AND `host`=?;", [
                $apiKey,
                $host
            ]
        );

        return $result->rowCount() !== 0;
    }
}