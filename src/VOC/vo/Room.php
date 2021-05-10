<?php


namespace VOC\vo;


class Room
{
    /** @var int */
    private $id;
    /** @var string */
    private $title;
    /** @var string */
    private $topic;
    /** @var string */
    private $bot;
    /** @var string */
    private $creator;
    /** @var boolean */
    private $allowedUsers;
    /** @var boolean */
    private $allowPics;
    /** @var boolean */
    private $premoder;
    /** @var int */
    private $lastAction;
    /** @var boolean */
    private $clubOnly;
    /** @var string */
    private $password;
    /** @var boolean */
    private $jail;
    /** @var int */
    private $points;

    public function __construct($id,
                                $title,
                                $topic,
                                $bot,
                                $creator,
                                $allowedUsers,
                                $allowPics,
                                $premoder,
                                $lastAction,
                                $clubOnly,
                                $password,
                                $jail,
                                $points)
    {
        $this->id = $id;
        $this->title = $title;
        $this->topic = $topic;
        $this->bot = $bot;
        $this->creator = $creator;
        $this->allowedUsers = $allowedUsers;
        $this->allowPics = $allowPics;
        $this->premoder = $premoder;
        $this->lastAction = $lastAction;
        $this->clubOnly = $clubOnly;
        $this->password = $password;
        $this->jail = $jail;
        $this->points = $points;
    }

    public static function fromState(array $data)
    {
        return new Room(
            isset($data['id']) ? $data['id'] : 0,
            isset($data['title']) ? $data['title'] : null,
            isset($data['topic']) ? $data['topic'] : null,
            isset($data['bot']) ? $data['bot'] : null,
            isset($data['creator']) ? $data['creator'] : null,
            isset($data['allowed_users']) && intval($data['allowed_users']) === 1,
            isset($data['allow_pics']) && intval($data['allow_pics']) === 1,
            isset($data['premoder']) && intval($data['premoder']) === 1,
            isset($data['last_action']) ? $data['last_action'] : 0,
            isset($data['clubonly']) && intval($data['clubonly']) === 1,
            isset($data['password']) ? $data['password'] : null,
            !isset($data['jail']) || intval($data['jail']) === 1,
            isset($data['points']) ? $data['points'] : 1
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
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getTopic()
    {
        return $this->topic;
    }

    /**
     * @param string $topic
     */
    public function setTopic($topic)
    {
        $this->topic = $topic;
    }

    /**
     * @param string $design
     */
    public function setDesign($design)
    {
        $this->design = $design;
    }

    /**
     * @return string
     */
    public function getBot()
    {
        return $this->bot;
    }

    /**
     * @param string $bot
     */
    public function setBot($bot)
    {
        $this->bot = $bot;
    }

    /**
     * @return bool
     */
    public function isJail()
    {
        return $this->jail;
    }

    /**
     * @param bool $jail
     */
    public function setJail($jail)
    {
        $this->jail = $jail;
    }

    /**
     * @return int
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * @param int $points
     */
    public function setPoints($points)
    {
        $this->points = $points;
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
    public function getCreator()
    {
        return $this->creator;
    }

    /**
     * @param string $creator
     */
    public function setCreator($creator)
    {
        $this->creator = $creator;
    }

    /**
     * @return bool
     */
    public function isAllowedUsers()
    {
        return $this->allowedUsers;
    }

    /**
     * @param bool $allowedUsers
     */
    public function setAllowedUsers($allowedUsers)
    {
        $this->allowedUsers = $allowedUsers;
    }

    /**
     * @return bool
     */
    public function isAllowPics()
    {
        return $this->allowPics;
    }

    /**
     * @param bool $allowPics
     */
    public function setAllowPics($allowPics)
    {
        $this->allowPics = $allowPics;
    }

    /**
     * @return bool
     */
    public function isPremoder()
    {
        return $this->premoder;
    }

    /**
     * @param bool $premoder
     */
    public function setPremoder($premoder)
    {
        $this->premoder = $premoder;
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

    /**
     * @return bool
     */
    public function isClubOnly()
    {
        return $this->clubOnly;
    }

    /**
     * @param bool $clubOnly
     */
    public function setClubOnly($clubOnly)
    {
        $this->clubOnly = $clubOnly;
    }
}