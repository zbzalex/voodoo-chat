<?php


namespace Chat\server;


class Handler
{
    private $update;
	public function __construct() {
        $this->update = new MutableData();
	}

	public function onConnected(Connection $connection) {

	    $connection->setUpdatedAt(\time());

	    $this->update->addObserver($connection);
        $this->update->setValue(sprintf("<%s>: connected\n", $connection->getIp()));
	}

	public function onData(Connection $connection, $data) {
	    $data = trim($data);
        $this->update->setValue(sprintf("<%s>: %s\r\n", $connection->getIp(), $data));

        $connection->setUpdatedAt(\time());
	}

	public function onDisconnected(Connection $connection) {
		$this->update->setValue(sprintf("<%s>: disconnected\n", $connection->getIp()));
	}
}
