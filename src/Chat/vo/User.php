<?php

namespace Chat\vo;


class User
{
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
    private $photo;
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
    private $invisible = false;
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

    public function __construct($id, $session, $nick, $password, $canonNick, $htmlNick, $sex)
    {
        $this->id = $id;
        $this->session = $session;
        $this->nick = $nick;
        $this->password = $password;
        $this->canonNick = $canonNick;
        $this->htmlNick = $htmlNick;
        $this->sex = $sex;
    }

    public static function fromState(array $data)
    {
        return new User(
            isset($data['id']) ? $data['id'] : 0,
            isset($data['session']) ? $data['session'] : null,
            isset($data['nick']) ? $data['nick'] : null,
            isset($data['password']) ? $data['password'] : null,
            isset($data['canon_nick']) ? $data['canon_nick'] : null,
            isset($data['html_nick']) ? $data['html_nick'] : null,
            isset($data['sex']) ? $data['sex'] : 0
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
}