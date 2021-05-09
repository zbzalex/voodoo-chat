<?php


namespace VOC\entity;

/**
 * @Entity
 * @Table(name="voc2_shop_products")
 */
class ShopProduct
{
    /**
     * @var int
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    private $id;

    /**
     * @var string
     * @Column(type="string")
     */
    private $title;

    /**
     * @var string
     * @Column(type="string")
     */
    private $image;

    /**
     * @var double
     * @Column(type="double")
     */
    private $price;
}