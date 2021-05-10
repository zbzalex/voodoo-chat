<?php


namespace VOC\vo;


class ShopProductType
{
    /** @var int */
    private $id;

    /** @var string */
    private $title;

    public function __construct($id, $title)
    {
        $this->id = $id;
        $this->title = $title;
    }

    public static function fromState(array $data)
    {
        return new ShopProductType(
            isset($data['id']) ? $data['id'] : 0,
            isset($data['title']) ? $data['title'] : null
        );
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }
}