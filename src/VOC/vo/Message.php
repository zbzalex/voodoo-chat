<?php


namespace VOC\vo;


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
    private $fromWithoutTags;
    /** @var string */
    private $fromSession;
    /** @var int */
    private $fromId;
    /** @var string */
    private $fromAvatar;
    /** @var string */
    private $to;
    /** @var string */
    private $toSession;
    /** @var int */
    private $toId;
    /** @var string */
    private $body;
    /** @var int */
    private $clanId;

    public function __construct($id,
                                $room,
                                $time,
                                $from,
                                $fromWithoutTags,
                                $fromSession,
                                $fromId,
                                $fromAvatar,
                                $to,
                                $toSession,
                                $toId,
                                $body,
                                $clanId)
    {
        $this->id = $id;
        $this->room = $room;
        $this->time = $time;
        $this->from = $from;
        $this->fromWithoutTags = $fromWithoutTags;
        $this->fromSession = $fromSession;
        $this->fromId = $fromId;
        $this->fromAvatar = $fromAvatar;
        $this->to = $to;
        $this->toSession = $toSession;
        $this->toId = $toId;
        $this->body = $body;
        $this->clanId = $clanId;
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
    public function getFromWithoutTags()
    {
        return $this->fromWithoutTags;
    }

    /**
     * @param string $fromWithoutTags
     */
    public function setFromWithoutTags($fromWithoutTags)
    {
        $this->fromWithoutTags = $fromWithoutTags;
    }

    /**
     * @return string
     */
    public function getFromSession()
    {
        return $this->fromSession;
    }

    /**
     * @param string $fromSession
     */
    public function setFromSession($fromSession)
    {
        $this->fromSession = $fromSession;
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
    public function getFromAvatar()
    {
        return $this->fromAvatar;
    }

    /**
     * @param string $fromAvatar
     */
    public function setFromAvatar($fromAvatar)
    {
        $this->fromAvatar = $fromAvatar;
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
     * @return string
     */
    public function getToSession()
    {
        return $this->toSession;
    }

    /**
     * @param string $toSession
     */
    public function setToSession($toSession)
    {
        $this->toSession = $toSession;
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

    /**
     * @return int
     */
    public function getClanId()
    {
        return $this->clanId;
    }

    /**
     * @param int $clanId
     */
    public function setClanId($clanId)
    {
        $this->clanId = $clanId;
    }
}