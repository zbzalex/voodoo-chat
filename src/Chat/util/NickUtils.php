<?php


namespace Chat\util;


class NickUtils
{
    public static function canon($nick)
    {
        return strtolower($nick);
    }
}