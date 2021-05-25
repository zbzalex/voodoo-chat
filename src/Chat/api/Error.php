<?php


namespace Chat\api;


class Error extends ApiResponse
{
    public $ok = false;
    public $data = null;

    public function __construct($errorMessage, $errorCode = 0)
    {
        $this->errorMessage = $errorMessage;
        $this->errorCode = $errorCode;
    }
}