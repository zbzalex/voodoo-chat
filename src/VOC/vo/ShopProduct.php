<?php


namespace VOC\vo;


class ShopProduct
{
    var $id;
    var $title;
    var $image;
    var $price;
    var $quantity;
    var $saled;
    var $vip;
    var $unlimited;
    var $category;
    var $action;

    public function __construct()
    {
    }

    public static function fromState(array $data)
    {
        return new ShopProduct();
    }
}
