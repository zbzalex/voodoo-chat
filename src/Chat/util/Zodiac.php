<?php


namespace VOC\util;


class Zodiac
{
    public static function getZodiac($day, $month)
    {
        switch ($month) {
            case 1:
                if ($day < 21) return "kozerog.jpg";
                else return "vodolei.jpg";
            case 2:
                if ($day < 21) return "vodolei.jpg";
                else return "ribi.jpg";
            case 3:
                if ($day < 21) return "ribi.jpg";
                else return "oven.jpg";
            case 4:
                if ($day < 21) return "oven.jpg";
                else return "telec.jpg";
            case 5:
                if ($day < 21) return "telec.jpg";
                else return "blizneci.jpg";
            case 6:
                if ($day < 22) return "blizneci.jpg";
                else return "rak.jpg";
            case 7:
                if ($day < 23) return "rak.jpg";
                else return "lev.jpg";
            case 8:
                if ($day < 24) return "lev.jpg";
                else return "deva.jpg";
            case 9:
                if ($day < 24) return "deva.jpg";
                else return "vesi.jpg";
            case 10:
                if ($day < 24) return "vesi.jpg";
                else return "scorpion.jpg";
            case 11:
                if ($day < 23) return "scorpion.jpg";
                else return "strelec.jpg";
            case 12:
                if ($day < 22) return "strelec.jpg";
                else return "kozerog.jpg";
            default:
                return "kozerog.jpg";
        }
    }
}