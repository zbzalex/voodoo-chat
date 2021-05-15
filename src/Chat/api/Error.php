<?php


namespace Chat\api;


class Error extends ApiResponse
{
    public $ok = false;
    public $data = null;

    public function __construct($errorMessage)
    {
        $this->errorMessage = $errorMessage;
    }
}