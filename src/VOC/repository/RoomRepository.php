<?php


namespace VOC\repository;


class RoomRepository
{
    public function __construct()
    {
    }

    public function getAll()
    {
        $rooms_file = @file(ROOT_DIR . "/data/rooms.dat");

        $room_ids = [];
        $rooms = [];

        $jail_id = 0;

        for ($rg_i = 0; $rg_i < count($rooms_file); $rg_i++) {
            if (strlen($rooms_file[$rg_i]) < 7) continue;
            $cr_ar = explode("\t", trim($rooms_file[$rg_i]), ROOM_TOTALFIELDS);
            if (intval($cr_ar[ROOM_ID]) == $cr_ar[ROOM_ID]) {
                $room_ids[] = $cr_ar[ROOM_ID];
                $ar_rooms[$cr_ar[ROOM_ID]] = $cr_ar;

                if (intval($cr_ar[ROOM_JAIL]) == 1) $jail_id = intval($cr_ar[ROOM_ID]);

                $rooms[$cr_ar[ROOM_ID]] = array("title" => $cr_ar[ROOM_TITLE],
                    "topic" => $cr_ar[ROOM_TOPIC],
                    "design" => $cr_ar[ROOM_DESIGN],
                    "bot" => $cr_ar[ROOM_BOT],
                    "jail" => $cr_ar[ROOM_JAIL],
                    "points" => $cr_ar[ROOM_POINTS]);
            }
        }
    }
}