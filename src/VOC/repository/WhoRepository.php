<?php


namespace VOC\repository;


use VOC\dao\WhoDao;

class WhoRepository
{
    private $whoDao;
    public function __construct(WhoDao $whoDao) {
        $this->whoDao = $whoDao;
    }

    public function getAll() {
        return $this->whoDao->getAllDeprecated();
    }
}