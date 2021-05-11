<?php


namespace VOC\vo;


class ShopProduct
{
    /** @var int */
    private $id;
    /** @var string */
    private $title;
    /** @var string */
    private $image;
    /** @var double */
    private $price;
    /** @var int */
    private $quantity;
    /** @var int */
    private $saled;
    /** @var boolean */
    private $vip;
    /** @var int */
    private $category;
    /** @var string */
    private $action;

    public function __construct($id, $title, $image, $price, $quantity, $saled, $vip, $category, $action)
    {
        $this->id = $id;
        $this->title = $title;
        $this->image = $image;
        $this->price = $price;
        $this->quantity = $quantity;
        $this->saled = $saled;
        $this->vip = $vip;
        $this->category = $category;
        $this->action = $action;
    }

    public static function fromState(array $data)
    {
        return null;
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

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * @return int
     */
    public function getSaled()
    {
        return $this->saled;
    }

    /**
     * @param int $saled
     */
    public function setSaled($saled)
    {
        $this->saled = $saled;
    }

    /**
     * @return bool
     */
    public function isVip()
    {
        return $this->vip;
    }

    /**
     * @param bool $vip
     */
    public function setVip($vip)
    {
        $this->vip = $vip;
    }

    /**
     * @return int
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param int $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    /**
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param string $action
     */
    public function setAction($action)
    {
        $this->action = $action;
    }
}
