<?php


namespace Chat\vo;


class Ban
{
    /** @var int */
    private $id;
    /** @var string */
    private $who;
    /** @var string */
    private $moder;
    /** @var string */
    private $cause;
    /** @var int */
    private $until;

    public function __construct($id, $who, $moder, $cause, $until)
    {
        $this->id = $id;
        $this->who = $who;
        $this->moder = $moder;
        $this->cause = $cause;
        $this->until = $until;
    }

    public static function fromState(array $data)
    {
        return new Ban(
            isset($data['id']) ? $data['id'] : 0,
            isset($data['who']) ? $data['who'] : null,
            isset($data['moder']) ? $data['moder'] : null,
            isset($data['cause']) ? $data['cause'] : null,
            isset($data['until']) ? $data['until'] : 0
        );
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getWho()
    {
        return $this->who;
    }

    /**
     * @param string $who
     */
    public function setWho($who)
    {
        $this->who = $who;
    }

    /**
     * @return mixed
     */
    public function getModer()
    {
        return $this->moder;
    }

    /**
     * @param mixed $moder
     */
    public function setModer($moder)
    {
        $this->moder = $moder;
    }

    /**
     * @return mixed
     */
    public function getCause()
    {
        return $this->cause;
    }

    /**
     * @param mixed $cause
     */
    public function setCause($cause)
    {
        $this->cause = $cause;
    }

    /**
     * @return mixed
     */
    public function getUntil()
    {
        return $this->until;
    }

    /**
     * @param mixed $until
     */
    public function setUntil($until)
    {
        $this->until = $until;
    }
}