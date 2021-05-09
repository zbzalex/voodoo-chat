<?php


namespace VOC\repository;


use VOC\dao\BanDao;

class BanRepository
{
    /**
     * @var BanDao
     */
    private $banDao;

    public function __construct(BanDao $banDao)
    {
        $this->banDao = $banDao;
    }

    public function exists()
    {

    }

    public function getAll()
    {
    }

    public function remove()
    {
    }
}