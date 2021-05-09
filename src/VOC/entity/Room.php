<?php


namespace VOC\entity;


/**
 * @Entity
 * @Table(name="voc2_rooms)
 */
class Room
{
    /**
     * @var int
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    private $id;
}