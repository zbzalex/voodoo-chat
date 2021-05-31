<?php


namespace Chat\server;


class MutableData
{
    /** @var Observer[] */
    private $observers = [];
    private $value;

    public function __construct($value = null)
    {
        $this->setValue($value);
    }

    public function addObserver(Observer $observer)
    {
        $this->observers[] = $observer;

        return $this;
    }

    public function setValue($value)
    {
        $this->value = $value;
        $this->notify();
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    public function notify()
    {
        for ($i = 0; $i < count($this->observers); $i++) {
            $observer = $this->observers[$i];
            $observer->onChanged($this->value);
        }
    }
}