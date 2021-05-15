<?php


namespace VOC\util;


class URL
{
    /** @var string */
    private $url;

    public function __construct($url)
    {
        $this->url = $url;
    }

    public function openConnection()
    {
        $fd = @fsockopen($this->url, 80, $errno, $errstr, 30);

        return $fd !== false;
    }
}