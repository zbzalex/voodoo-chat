<?php


namespace Chat\api;


class Ok extends ApiResponse
{
    public $ok = true;
    public $errorMessage = null;
    public $errorCode = 0;

    public function __construct(array $data = []) {
        $this->data = $data;
    }
}