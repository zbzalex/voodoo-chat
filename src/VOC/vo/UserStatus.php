<?php


namespace VOC\vo;


class UserStatus
{
    const ONLINE = 0;
    const DISCONNECTED = 1;
    const AWAY = 2;
    const NA = 4;
    const DND = 8;
    const __PRIVATE = 16;
}