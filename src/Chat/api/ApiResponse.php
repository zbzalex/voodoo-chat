<?php


namespace Chat\api;


abstract class ApiResponse
{
    public $ok = false;
    public $data = null;
    public $errorMessage = null;
    public $errorCode = 0;
}