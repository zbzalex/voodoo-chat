<?php

namespace Chat\server;


class Server
{
    private $port;
    private $handler;
    private $clientSocketArray = [];
    private $clientSocketArrayTimestamps = [];

    public function __construct($port, Handler $handler)
    {
        $this->port = $port;
        $this->handler = $handler;
        $this->start();
    }

    private function start()
    {
        $null = null;
        $sock = @socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        @socket_set_option($sock, SOL_SOCKET, SO_REUSEADDR, 1);
        @socket_bind($sock, 0, $this->port);
        @socket_listen($sock);

        $this->clientSocketArray = [$sock];
        $this->clientSocketArrayTimestamps = [0];

        while (1) {
            $this->clientSocketArray = array_values($this->clientSocketArray);
            $this->clientSocketArrayTimestamps = array_values($this->clientSocketArrayTimestamps);

            // kick expired
            if (count($this->clientSocketArray) > 1) {
                for ($i = 1; $i < count($this->clientSocketArray); $i++) {
                    if ($this->isExpired($this->clientSocketArray[$i])) {
                        $this->kick($this->clientSocketArray[$i]);
                    }
                }
            }

            $changed = $this->clientSocketArray;
            @socket_select($changed, $null, $null, 0, 10);
            if (in_array($sock, $changed)) {
                $newSocket = @socket_accept($sock);
                $this->clientSocketArray[] = $newSocket;
                $this->clientSocketArrayTimestamps[] = time();
                $this->handler->onConnected(new Connection($newSocket));
                if (($pos = array_search($sock, $changed))) {
                    unset($changed[$pos]);
                }
            }

            $changed = array_values($changed);
            for ($i = 0; $i < count($changed); $i++) {
                $changedSock = $changed[$i];
                $connection = new Connection($changedSock);
                $connection->recvData(new DataListener($this->handler));
                if (($pos = array_search($changedSock, $this->clientSocketArray)) != -1) {
                    $this->clientSocketArrayTimestamps[$pos] = time();
                }
            }
        }
        @socket_close($sock);
    }

    public function isExpired($sock)
    {
        if (($pos = array_search($sock, $this->clientSocketArray)) != -1) {
            $timestamp = $this->clientSocketArrayTimestamps[$pos];
            return $timestamp < time() - 60;
        }

        return false;
    }

    public function kick($sock)
    {
        if (($pos = array_search($sock, $this->clientSocketArray)) != -1) {
            $this->handler->onDisconnected(new Connection($sock));
            @socket_close($sock);
            unset($this->clientSocketArray[$pos]);
            unset($this->clientSocketArrayTimestamps[$pos]);
        }
    }
}
