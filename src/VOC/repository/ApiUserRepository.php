<?php


namespace VOC\repository;


use VOC\dao\ApiUserDao;

class ApiUserRepository
{
    private $apiUserDao;

    public function __construct(ApiUserDao $apiUserDao)
    {
        $this->apiUserDao = $apiUserDao;
    }

    public function getByApiKeyAndHost($apiKey, $host)
    {
        return $this->apiUserDao->getByApiKeyAndHost($apiKey, $host);
    }
}