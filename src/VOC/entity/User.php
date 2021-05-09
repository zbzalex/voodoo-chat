<?php


namespace VOC\entity;

/**
 * @Entity
 * @Table(name="voc2_users")
 */
class User
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
    private $nickname;

    /**
     * @var string
     * @Column(type="string")
     */
    private $password;

    /**
     * @var string
     * @Column(type="integer")
     */
    private $class;
}