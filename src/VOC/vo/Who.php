<?php


namespace VOC\vo;


class Who
{
    /** @var int */
    private $id;
    /** @var string */
    private $nickname;
    /** @var string */
    private $session;
    /** @var int */
    private $time;
    /** @var int */
    private $gender;
    /** @var string */
    private $avatar;
    /** @var int */
    private $regId;
    /** @var int */
    private $tailId;
    /** @var string */
    private $ip;
    /** @var int */
    private $status;
    /** @var int */
    private $lastSayTime;
    /** @var int */
    private $room;


    private $ignorList; // deprecated

    /** @var string */
    private $canonNick;

    /** @var string */
    private $chatType; // deprecated
    /** @var string */
    private $lang; // deprecated

    /** @var string */
    private $htmlNick;

    private $privTailId; // deprecated

    private $cookie; // deprecated
    private $browserHash; // deprecated

    /** @var int */
    private $class;

    private $skin; // deprecated

    /** @var boolean */
    private $invisible;

    private $silence;
    private $silenceStart;

    private $filter;

    private $customClass;

    /** @var int */
    private $clanId;

    private $reduceTraffic; // deprecated

    /** @var boolean */
    private $registered;

    private $member;

    private $shmId; // deprecated

    public function __construct($id,
                                $nickname,
                                $session,
                                $time,
                                $gender,
                                $avatar,
                                $regId,
                                $tailId,
                                $ip,
                                $status,
                                $lastSayTime,
                                $room,
                                $ignorList,
                                $canonNick,
                                $chatType,
                                $lang,
                                $htmlNick,
                                $privTailId,
                                $cookie,
                                $browserHash,
                                $class,
                                $skin,
                                $invisible,
                                $silence,
                                $silenceStart,
                                $filter,
                                $customClass,
                                $clanId,
                                $reduceTraffic,
                                $registered,
                                $member,
                                $shmId)
    {
        $this->id = $id;
        $this->nickname = $nickname;
        $this->session = $session;
        $this->time = $time;
        $this->gender = $gender;
        $this->avatar = $avatar;
        $this->regId = $regId;
        $this->tailId = $tailId;
        $this->ip = $ip;
        $this->status = $status;
        $this->lastSayTime = $lastSayTime;
        $this->room = $room;
        $this->ignorList = $ignorList;
        $this->canonNick = $canonNick;
        $this->chatType = $chatType;
        $this->lang = $lang;
        $this->htmlNick = $htmlNick;
        $this->privTailId = $privTailId;
        $this->cookie = $cookie;
        $this->browserHash = $browserHash;
        $this->class = $class;
        $this->skin = $skin;
        $this->invisible = $invisible;
        $this->silence = $silence;
        $this->silenceStart = $silenceStart;
        $this->filter = $filter;
        $this->customClass = $customClass;
        $this->clanId = $clanId;
        $this->reduceTraffic = $reduceTraffic;
        $this->registered = $registered;
        $this->member = $member;
        $this->shmId = $shmId;
    }

    public static function fromState(array $data)
    {
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
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getNickname()
    {
        return $this->nickname;
    }

    /**
     * @param string $nickname
     */
    public function setNickname($nickname)
    {
        $this->nickname = $nickname;
    }

    /**
     * @return int
     */
    public function getRegId()
    {
        return $this->regId;
    }

    /**
     * @param int $regId
     */
    public function setRegId($regId)
    {
        $this->regId = $regId;
    }

    /**
     * @return string
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * @param string $session
     */
    public function setSession($session)
    {
        $this->session = $session;
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
     * @return int
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param int $gender
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    /**
     * @return string
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * @param string $avatar
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;
    }

    /**
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @param string $ip
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return int
     */
    public function getLastSayTime()
    {
        return $this->lastSayTime;
    }

    /**
     * @param int $lastSayTime
     */
    public function setLastSayTime($lastSayTime)
    {
        $this->lastSayTime = $lastSayTime;
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
     * @return mixed
     */
    public function getIgnorList()
    {
        return $this->ignorList;
    }

    /**
     * @param mixed $ignorList
     */
    public function setIgnorList($ignorList)
    {
        $this->ignorList = $ignorList;
    }

    /**
     * @return bool
     */
    public function isRegistered()
    {
        return $this->registered;
    }

    /**
     * @param bool $registered
     */
    public function setRegistered($registered)
    {
        $this->registered = $registered;
    }

    /**
     * @return bool
     */
    public function isInvisible()
    {
        return $this->invisible;
    }

    /**
     * @param bool $invisible
     */
    public function setInvisible($invisible)
    {
        $this->invisible = $invisible;
    }

    /**
     * @return string
     */
    public function getCanonNick()
    {
        return $this->canonNick;
    }

    /**
     * @param string $canonNick
     */
    public function setCanonNick($canonNick)
    {
        $this->canonNick = $canonNick;
    }

    /**
     * @return string
     */
    public function getHtmlNick()
    {
        return $this->htmlNick;
    }

    /**
     * @param string $htmlNick
     */
    public function setHtmlNick($htmlNick)
    {
        $this->htmlNick = $htmlNick;
    }

    /**
     * @return int
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @param int $class
     */
    public function setClass($class)
    {
        $this->class = $class;
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