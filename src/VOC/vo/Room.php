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

    private $creator;

    private $allowedUsers;

    private $lastAction;
    /** @var boolean */
    private $clubOnly;
    /** @var string */
    private $password;

    /** @var boolean */
    private $jail;
    /** @var int */
    private $points;

    public function __construct($id, $title, $topic, $bot, $creator, $jail, $points)
    {
        $this->id = $id;
        $this->title = $title;
        $this->topic = $topic;
        $this->bot = $bot;
        $this->creator = $creator;
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
            isset($data['jail']) ? $data['jail'] : true,
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
}