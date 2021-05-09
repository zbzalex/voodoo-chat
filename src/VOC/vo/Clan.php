<?php


namespace VOC\vo;


class Clan
{
    var $name = "";
    var $registration_time = 0;
    var $url = "";
    var $email = "";
    var $border = 0;
    var $members = array();
    var $ustav = "";
    var $greeting = "";
    var $goodbye = "";
    var $credits = 0;
    var $money_log = array();

    public function __construct()
    {
    }

    public static function fromState(array $data)
    {

    }
}
