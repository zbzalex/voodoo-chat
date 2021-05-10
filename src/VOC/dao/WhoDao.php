<?php


namespace VOC\dao;


use VOC\db\Dao;
use VOC\vo\Who;

class WhoDao extends Dao
{
    /** @deprecated */
    public function getAllDeprecated()
    {
        $entities = [];
        $rows = @file(ROOT_DIR . "/data/who.dat");
        if ($rows !== false && count($rows) > 0) {
            for ($i = 0; $i < count($rows); $i++) {
                $row = explode("\t", $rows[$i]);
                $entities[] = new Who(
                    0,
                    $row[0], // nickname
                    $row[1], // session
                    intval($row[2]), // time
                    intval($row[3]), // gender
                    strlen($row[4]) === 0 ? null : $row[4], // avatar,
                    intval($row[5]), // regid,
                    $row[6], // tailid
                    $row[7], // ip
                    intval($row[8]), // status
                    intval($row[9]), // lastsaytime
                    intval($row[10]),// room
                    $row[11],
                    $row[12], // canonical nick
                    $row[13],
                    $row[14],
                    $row[15],
                    $row[16],
                    $row[17],
                    $row[18],
                    $row[19],
                    $row[20],
                    $row[21],
                    $row[22],
                    $row[23],
                    $row[24],
                    $row[25],
                    intval($row[26]),
                    $row[27],
                    intval($row[28]) === 1,
                    $row[29],
                    $row[30]
                );
            }

            return $entities;
        }

        return null;
    }

    /** @deprecated */
    public function removeByNicknameDeprecated($nickname)
    {
        $rows = @file(ROOT_DIR . "/data/who.dat");
        if ($rows !== false && count($rows) > 0) {
            $tmp = [];
            for ($i = 0; $i < count($rows); $i++) {
                $row = explode("\t", $rows[$i]);
                if ($row[0] !== $nickname) {
                    $tmp[] = $row;
                }
            }

            $fd = @fopen(ROOT_DIR . "/data/who.dat", "rw+");
            if ($fd !== false) {
                fseek($fd, 0);
                fwrite($fd, implode("\n", $tmp));
                fclose($fd);
            }
        }

        return null;
    }
}