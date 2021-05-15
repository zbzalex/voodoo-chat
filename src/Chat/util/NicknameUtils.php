<?php


namespace VOC\util;


class NicknameUtils
{
    public static function canon($nick)
    {
        return strtolower($nick);
    }
}