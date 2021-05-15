<?php


namespace Chat\vo;


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
    /** @var boolean */
    private $allowedUsers;
    /** @var int */
    private $lastAction;
    /** @var string */
    private $password;
    /** @var boolean */
    private $jail;
    /** @var int */
    private $points;
    /** @var int */
    private $createdAt;
    /** @var int */
    private $updatedAt;

    public function __construct($id,
                                $title,
                                $topic,
                                $bot,
                                $allowedUsers,
                                $lastAction,
                                $password,
                                $jail,
                                $points,
                                $createdAt,
                                $updatedAt)
    {
        $this->id = $id;
        $this->title = $title;
        $this->topic = $topic;
        $this->bot = $bot;
        $this->allowedUsers = $allowedUsers;
        $this->lastAction = $lastAction;
        $this->password = $password;
        $this->jail = $jail;
        $this->points = $points;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    public static function fromState(array $data)
    {
        return new Room(
            isset($data['id']) ? $data['id'] : 0,
            isset($data['title']) ? $data['title'] : null,
            isset($data['topic']) ? $data['topic'] : null,
            isset($data['bot']) ? $data['bot'] : null,
            isset($data['allowed_users']) && intval($data['allowed_users']) === 1,
            isset($data['last_action']) ? $data['last_action'] : 0,
            isset($data['password']) ? $data['password'] : null,
            !isset($data['jail']) || intval($data['jail']) === 1,
            isset($data['points']) ? $data['points'] : 1,
            isset($data['created_at']) ? $data['created_at'] : 0,
            isset($data['updated_at']) ? $data['updated_at'] : 0
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
     * @return int
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param int $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return int
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param int $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }
}