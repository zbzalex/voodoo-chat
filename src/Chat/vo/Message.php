<?php


namespace Chat\vo;


class Message
{
    /** @var int */
    private $id;
    /** @var int */
    private $room;
    /** @var int */
    private $time;
    /** @var string */
    private $from;
    /** @var string */
    private $fromCanonNick;
    /** @var int */
    private $fromId;
    /** @var string */
    private $to;
    /** @var int */
    private $toId;
    /** @var string */
    private $body;

    public function __construct($id,
                                $room,
                                $time,
                                $from,
                                $fromCanonNick,
                                $fromId,
                                $to,
                                $toId,
                                $body)
    {
        $this->id = $id;
        $this->room = $room;
        $this->time = $time;
        $this->from = $from;
        $this->fromCanonNick = $fromCanonNick;
        $this->fromId = $fromId;
        $this->to = $to;
        $this->toId = $toId;
        $this->body = $body;
    }

    public static function fromState(array $data)
    {
        //return new Message();
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
     * @return int
     */
    public function getRoom()
    {
        return $this->room;
    }

    /**
     * @param int $room
     */
    public function setRoom($room)
    {
        $this->room = $room;
    }

    /**
     * @return int
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @param int $time
     */
    public function setTime($time)
    {
        $this->time = $time;
    }

    /**
     * @return string
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @param string $from
     */
    public function setFrom($from)
    {
        $this->from = $from;
    }

    /**
     * @return string
     */
    public function getFromCanonNick()
    {
        return $this->fromCanonNick;
    }

    /**
     * @param string $fromCanonNick
     */
    public function setFromWithoutTags($fromCanonNick)
    {
        $this->fromCanonNick = $fromCanonNick;
    }

    /**
     * @return int
     */
    public function getFromId()
    {
        return $this->fromId;
    }

    /**
     * @param int $fromId
     */
    public function setFromId($fromId)
    {
        $this->fromId = $fromId;
    }

    /**
     * @return string
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * @param string $to
     */
    public function setTo($to)
    {
        $this->to = $to;
    }

    /**
     * @return int
     */
    public function getToId()
    {
        return $this->toId;
    }

    /**
     * @param int $toId
     */
    public function setToId($toId)
    {
        $this->toId = $toId;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param string $body
     */
    public function setBody($body)
    {
        $this->body = $body;
    }
}