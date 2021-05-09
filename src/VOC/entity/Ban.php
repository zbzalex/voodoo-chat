<?php


namespace VOC\entity;

/**
 * @Entity
 * @Table(name="voc2_ban")
 */
class Ban
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
    private $who;

    /**
     * @var string
     * @Column(type="string")
     */
    private $moder;

    /**
     * @var string
     * @Column(type="string")
     */
    private $cause;

    /**
     * @var int
     * @Column(type="integer")
     */
    private $until;
}