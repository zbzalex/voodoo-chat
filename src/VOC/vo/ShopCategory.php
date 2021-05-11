<?php


namespace VOC\vo;


class ShopCategory
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
        return new ShopCategory(
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
    public function setId($id)
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
    public function setTitle($title)
    {
        $this->title = $title;
    }
}