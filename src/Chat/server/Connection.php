<?php


namespace Chat\server;


class Connection implements Observer
{
    private $socket;
    private $ip;
    private $updatedAt;

    public function __construct($socket)
    {
        $this->socket = $socket;
    }

    public function getSocket()
    {
        return $this->socket;
    }

    public function getIp()
    {
        if ($this->ip === null) {
            @socket_getpeername($this->socket, $ip);
            $this->ip = $ip;
        }

        return $this->ip;
    }

    public function recvData(DataListener $listener)
    {
        while (@socket_recv($this->socket, $buf, 2048, 0) >= 1) {
            $listener->onDataReceived($this, $buf);

            break;
        }
    }

    public function onChanged($value)
    {
        @socket_write($this->socket, $value);
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param mixed $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }
}
