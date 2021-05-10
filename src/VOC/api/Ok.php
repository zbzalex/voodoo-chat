<?php


namespace VOC\api;


class Ok extends ApiResponse
{
    public $ok = true;
    public $errorMessage = null;

    public function __construct(array $data = []) {
        $this->data = json_encode($data);
    }
}