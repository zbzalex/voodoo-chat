<?php


namespace Chat\api;


abstract class ApiResponse
{
    public $ok = false;
    public $data = null;
    public $errorMessage = null;

    public function __toString() {
        if ($this->data === null) {
            unset($this->data);
        }

        if ($this->errorMessage === null) {
            unset($this->errorMessage);
        }

        return json_encode($this);
    }
}