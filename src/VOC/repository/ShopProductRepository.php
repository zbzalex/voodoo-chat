<?php


namespace VOC\repository;


class ShopProductRepository
{
    private $shopProductDao;

    public function __construct(ShopProductDao $shopProductDao)
    {
        $this->shopProductDao = $shopProductDao;
    }
}