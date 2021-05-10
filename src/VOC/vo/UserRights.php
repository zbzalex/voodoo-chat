<?php


namespace VOC\vo;


class UserRights
{
    const ADM_BAN = 1;
    const ADM_IP_BAN = 2;
    const ADM_VIEW_IP = 4;
    const ADM_UN_BAN = 8;
    const ADM_BAN_MODERATORS = 16;
    const ADM_CHANGE_TOPIC = 32;
    const ADM_CREATE_ROOMS = 64;
    const ADM_EDIT_USERS = 128;
//    const ADM_BAN_BY_BROWSERHASH = 256;
//    const ADM_BAN_BY_SUBNET = 512;
    const ADM_VIEW_PRIVATE = 1024;

    const VIP = -1;
}