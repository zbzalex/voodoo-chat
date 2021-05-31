<?php

namespace Chat\server;


class Server
{
	private $port;
	private $handler;
	public function __construct($port, Handler $handler) {
		$this->port = $port;
		$this->handler = $handler;
		$this->start();
	}

	private function start() {
		$null = null;
		$sock = @socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
		@socket_set_option($sock, SOL_SOCKET, SO_REUSEADDR, 1);
		@socket_bind($sock, 0, $this->port);
		@socket_listen($sock);
		$clients = [$sock];
		while(1) {
			$changed = $clients;
			@socket_select($changed, $null, $null, 0, 10);
			if (in_array($sock, $changed)) {
				$newSocket = @socket_accept($sock);
				$clients[] = $newSocket;
				$this->handler->onConnected(new Connection($newSocket));
				if (($foundSocketIndex = array_search($sock, $changed))) {
					unset($changed[$foundSocketIndex]);
				}
			}

			$changed = array_values($changed);
			for($i = 0; $i < count($changed); $i++) {
				$changedSock = $changed[$i];
				$connection = new Connection($changedSock);
				$connection->recvData(new DataListener($this->handler));
				// ..
			}
		}
		@socket_close($sock);
	}
}
