<?php

namespace Chat\vo;


class User
{
    const SEX_UNKNOWN = 0;
    const SEX_FEMALE = 1;
    const SEX_MALE = 2;

    const CLASS_BAN = 256;
    const CLASS_EDIT_USER = 1024;

    const CLASS_VIP = -1;

    /** @var int */
    private $id;
    /** @var string */
    private $session;
    /** @var string */
    private $nick;
    /** @var string */
    private $password;
    /** @var string */
    private $canonNick;
    /** @var string */
    private $htmlNick;
    /** @var int */
    private $sex;
    /** @var int */
    private $lastAction;
    /** @var int */
    private $room;
    /** @var int */
    private $status;

    /** @var string */
    private $photoUrl;
    /** @var int */
    private $photoRating = 0;

    /** @var int */
    private $points = 0;
    /** @var int */
    private $credits = 0;
    /** @var int */
    private $firstName;
    /** @var string */
    private $lastName;
    /** @var string */
    private $email;
    /** @var string */
    private $about;
    /** @var int */
    private $class;
    /** @var int */
    private $bDay = 1;
    /** @var int */
    private $bMonth = 1;
    /** @var int */
    private $bYear = 1970;
    /** @var string */
    private $city;
    /** @var int */
    private $marriedWith;
    /** @var string */
    private $enterPhrase;
    /** @var string */
    private $leavePhrase;
    /** @var int */
    private $damneds = 0;
    /** @var int */
    private $rewards = 0;
    /** @var string */
    private $ip;
    /** @var string */
    private $userAgent;
    /** @var int */
    private $referredBy;
    /** @var int */
    private $onlineTime = 0;
    /** @var boolean */
    private $invis = false;
    /** @var int */
    private $silence = 0;
    /** @var int */
    private $silenceStart = 0;
    /** @var bool */
    private $filter = false;
    /** @var int */
    private $createdAt = 0;
    /** @var int */
    private $updatedAt = 0;
    /** @var bool  */
    private $bot = false;

    public function __construct($id, $session, $nick, $password, $canonNick, $htmlNick, $sex,
        $class)
    {
        $this->id = $id;
        $this->session = $session;
        $this->nick = $nick;
        $this->password = $password;
        $this->canonNick = $canonNick;
        $this->htmlNick = $htmlNick;
        $this->sex = $sex;
        $this->class = $class;
    }

    public static function fromState(array $data)
    {
        return new User(
            isset($data['id']) ? intval($data['id']) : 0,
            isset($data['session']) ? $data['session'] : null,
            isset($data['nick']) ? $data['nick'] : null,
            isset($data['password']) ? $data['password'] : null,
            isset($data['canon_nick']) ? $data['canon_nick'] : null,
            isset($data['html_nick']) ? $data['html_nick'] : null,
            isset($data['sex']) ? intval($data['sex']) : 0,
            isset($data['class']) ? intval($data['class']) : 0
        );
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
     * @return string
     */
    public function getNick()
    {
        return $this->nick;
    }

    /**
     * @param string $nick
     */
    public function setNick($nick)
    {
        $this->nick = $nick;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
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
    public function getSex()
    {
        return $this->sex;
    }

    /**
     * @param int $sex
     */
    public function setSex($sex)
    {
        $this->sex = $sex;
    }

    /**
     * @return string
     */
    public function getPhotoUrl()
    {
        return $this->photoUrl;
    }

    /**
     * @param string $photoUrl
     */
    public function setPhotoUrl($photoUrl)
    {
        $this->photoUrl = $photoUrl;
    }

    /**
     * @return int
     */
    public function getRewards()
    {
        return $this->rewards;
    }

    /**
     * @param int $rewards
     */
    public function setRewards($rewards)
    {
        $this->rewards = $rewards;
    }

    /**
     * @return int
     */
    public function getDamneds()
    {
        return $this->damneds;
    }

    /**
     * @param int $damneds
     */
    public function setDamneds($damneds)
    {
        $this->damneds = $damneds;
    }

    /**
     * @return int
     */
    public function getMarriedWith()
    {
        return $this->marriedWith;
    }

    /**
     * @param int $marriedWith
     */
    public function setMarriedWith($marriedWith)
    {
        $this->marriedWith = $marriedWith;
    }

    /**
     * @return bool
     */
    public function isBot()
    {
        return $this->bot;
    }

    /**
     * @param bool $bot
     */
    public function setBot($bot)
    {
        $this->bot = $bot;
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
    public function getOnlineTime()
    {
        return $this->onlineTime;
    }

    /**
     * @param int $onlineTime
     */
    public function setOnlineTime($onlineTime)
    {
        $this->onlineTime = $onlineTime;
    }

    /**
     * @return int
     */
    public function getSilence()
    {
        return $this->silence;
    }

    /**
     * @param int $silence
     */
    public function setSilence($silence)
    {
        $this->silence = $silence;
    }

    /**
     * @return int
     */
    public function getSilenceStart()
    {
        return $this->silenceStart;
    }

    /**
     * @param int $silenceStart
     */
    public function setSilenceStart($silenceStart)
    {
        $this->silenceStart = $silenceStart;
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
    public function getLastAction()
    {
        return $this->lastAction;
    }

    /**
     * @param int $lastAction
     */
    public function setLastAction($lastAction)
    {
        $this->lastAction = $lastAction;
    }
}