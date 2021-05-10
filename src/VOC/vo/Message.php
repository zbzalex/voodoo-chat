<?php


namespace VOC\vo;


class Message
{
    /** @var int */
    private $id;

    public function __construct() {}

    public static function fromState(array $data) {
        return new Message();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }
}