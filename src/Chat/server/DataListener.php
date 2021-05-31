<?php


namespace Chat\server;


class DataListener
{
	private $handler;
	public function __construct(Handler $handler) {
		$this->handler = $handler;
	}

	public function onDataReceived(Connection $connection, $data) {
		$this->handler->onData($connection, $data);
	}
}
