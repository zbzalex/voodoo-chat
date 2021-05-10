<?php


namespace VOC\dao;


use VOC\db\Dao;

class ApiUserDao extends Dao
{
    private static $TABLE = "api_users";

    public function getByApiKeyAndHost($apiKey, $host) {
        $result = $this->db->executeNativeQuery(
            'SELECT * FROM `' . self::$TABLE . '` WHERE `api_key`=? AND `host`=?;', [
                $apiKey,
                $host
            ]
        );

        return $result->rowCount() !== 0;
    }
}