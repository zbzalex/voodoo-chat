<?php

function guardChat(&$id)
{
// $id - new user id
// returns: 0 if db is corrupted, 1 otherwise
    global $data_path, $user_data_file;

    //maybe future transaction was incomplete, then WAL engine automatically tries to recover the db if possible
    StartupWALEngine();

    //starting new transaction log
    $fp = fopen($data_path . "users/wal.dat", "wb");
    if (!$fp) {
        AddToGuardianLog("WAL: �� ���� ������� " . $data_path . "users/wal.dat" . " ��� ������. ����������, ��������� ����������.");
        trigger_error("WAL: �� ���� ������� " . $data_path . "users/wal.dat" . " ��� ������. ����������, ��������� ����������.", E_USER_ERROR);
        exit;
    }
    if (!flock($fp, LOCK_EX)) {
        AddToGuardianLog("WAL: �� ���� ������������ " . $data_path . "users/wal.dat ���������� (flock error).");
        trigger_error("WAL: �� ���� ������������ " . $data_path . "users/wal.dat ���������� (flock error).", E_USER_ERROR);
        exit;
    }

    fwrite($fp, date("H:i:s d-m-Y") . "\t" . WAL_START . "\tWAL_START\n");
    fwrite($fp, date("H:i:s d-m-Y") . "\t" . GUARDIANDAT_READ_START . "\tGUARDIANDAT_READ_START\n");

    $fp_dat = fopen($data_path . "users/guardian.dat", "r+b");

    if (!$fp_dat) {
        AddToGuardianLog("�� ���� ������� " . $data_path . "users/guardian.dat � ������ ������!");
        trigger_error("�� ���� ������� " . $data_path . "users/guardian.dat � ������ ������!", E_USER_ERROR);
        exit;
    }
    if (!flock($fp_dat, LOCK_EX)) {
        AddToGuardianLog("�� ���� ������������ " . $data_path . "users/guardian.dat � ����������� ������ (flock)!");
        trigger_error("�� ���� ������������ " . $data_path . "users/guardian.dat � ����������� ������ (flock)!", E_USER_ERROR);
        exit;
    }


    fwrite($fp, date("H:i:s d-m-Y") . "\t" . GUARDIANDAT_WRITE_START . "\tGUARDIANDAT_WRITE_START\n");

    fseek($fp_dat, 0);

    if (fwrite($fp_dat, $id) === FALSE) {
        AddToGuardianLog("�� ���� �������� ������ � guradian.dat -- ���� �����?");
        trigger_error("�� ���� �������� ������ � guradian.dat -- ���� �����?", E_USER_ERROR);
        exit;
    }

    fwrite($fp, date("H:i:s d-m-Y") . "\t" . GUARDIANDAT_WRITE_END . "\tGUARDIANDAT_WRITE_END\n");

    fwrite($fp, date("H:i:s d-m-Y") . "\t" . USERSDAT_READ_START . "\tUSERSDAT_READ_START\n");
    if (copy($data_path . "users.dat", $data_path . "users/users-backup.dat") === FALSE) {
        AddToGuardianLog("�� ���� ����������� " . $data_path . "users.dat" . " � " . $data_path . "users/users-backup.dat ����������, ��������� ����������.");
        trigger_error("�� ���� ����������� " . $data_path . "users.dat" . " � " . $data_path . "users/users-backup.dat ����������, ��������� ����������.", E_USER_ERROR);
        exit;
    }

    fwrite($fp, date("H:i:s d-m-Y") . "\t" . USERSDAT_READ_END . "\tUSERSDAT_READ_END\n");

    flock($fp, LOCK_UN);
    fclose($fp);

    flock($fp_dat, LOCK_UN);
    fclose($fp_dat);
    return 1;
}

define("WAL_START", 1);
define("GUARDIANDAT_READ_START", 2);
define("GUARDIANDAT_READ_END", -2);
define("GUARDIANDAT_WRITE_START", 3);
define("GUARDIANDAT_WRITE_END", -3);
define("USERSDAT_READ_START", 4);
define("USERSDAT_READ_END", -4);
define("USERSDAT_WRITE_START", 5);
define("USERSDAT_WRITE_END", -5);
define("WAL_END", -1);

function StartupWALEngine()
{
    global $data_path;
// log format
// <timestamp>\t<action id>\t<mnemocode>


    $fp = fopen($data_path . "users/wal.dat", "w+b");
    if (!$fp) {
        AddToGuardianLog("WAL: �� ���� ������� " . $data_path . "users/wal.dat" . " ��� ������. ����������, ��������� ����������.");
        trigger_error("WAL: �� ���� ������� " . $data_path . "users/wal.dat" . " ��� ������. ����������, ��������� ����������.", E_USER_ERROR);
        exit;
    }
    if (!flock($fp, LOCK_EX)) {
        AddToGuardianLog("WAL: �� ���� ������������ " . $data_path . "users/wal.dat ���������� (flock error).");
        trigger_error("WAL: �� ���� ������������ " . $data_path . "users/wal.dat ���������� (flock error).", E_USER_ERROR);
        exit;
    }
    // WAL engine couldnot be setup, for security reasons regostration MUST be failed.

    //checking WAL integrity
    //start markers array
    $start_arr = array();
    //end markers array
    $end_arr = array();

    //filling arrays
    $walContent = "";
    while ($line = fgets($fp, 16384)) {
        if (strlen($line) < 7) continue;
        $wal_array = explode("\t", trim($line));

        $action = floatval($wal_array[1]);
        if ($action == 0.00) continue;

        $walContent .= $line;

        if ($action > 0) {
            // this is a startup marker
            $start_arr[] = intval($action);
        } else {
            // this is a end marker
            $end_arr[] = floatval($action);
        }
    }

    if (count($start_arr) != count($end_arr)) {
        // wal error! some transactions were not finished!
        AddToGuardianLog("WAL: ���������� ���������� �� ���� ���������! ���������� ����:");
        AddToGuardianLog($walContent);

        $str = "����������� �����: ";
        for ($i = 0; $i < count($start_arr); $i++) $str .= $start_arr[$i] . " ";

        AddToGuardianLog($str . " (" . count($start_arr) . ")");

        $str = "����������� �����: ";
        for ($i = 0; $i < count($end_arr); $i++) $str .= $end_arr[$i] . " ";

        AddToGuardianLog($str . " (" . count($end_arr) . ")");

        reindexUsersDb();

        ftruncate($fp, 0);
        flock($fp, LOCK_UN);
        fclose($fp);
        return;
    }

    flock($fp, LOCK_UN);
    fclose($fp);
}

function reindexUsersDb()
{
    global $data_path, $user_data_file;

    AddToGuardianLog("��������������� ���� ������ �������������.");

    //backuping existing file
    copy($data_path . "users.dat", $data_path . "users/backup/users-bad-" . date("d-m-Y") . ".dat");

    //determining good one
    if (intval(filesize($data_path . "users/users.dat")) > intval(filesize($data_path . "users/users-backup.dat"))) {
        $good = "users.dat";
    } else {
        $good = "users-backup.dat";
    }

    //copying good one
    if (copy($data_path . "users/" . $good, $data_path . "users.dat") === FALSE) {
        //db is not ready, we cannot repair it for now
        sleep(2);
        if (copy($data_path . "users/" . $good, $data_path . "users.dat") === FALSE) {
            //giving up for some reason
            AddToGuardianLog("�� ������� ����������� " . $data_path . "users/" . $good . " � " . $data_path . "users.dat -- ���� �����?");
            trigger_error("�� ������� ����������� " . $data_path . "users/" . $good . " � " . $data_path . "users.dat -- ���� �����?", E_USER_ERROR);
            exit;
        }
    }

    $fp_b = fopen($user_data_file, "rb");
    $t_id = 0;
    if ($fp_b) {
        while ($user = fgets($fp_b, 4096)) {
            $u_data = explode("\t", str_replace("\r", "", str_replace("\n", "", ($user))));
            if (intval($u_data[0]) > $t_id) $t_id = intval($u_data[0]);
        }
        fclose($fp_b);
    } else {
        AddToGuardianLog("�� ���� ������� " . $user_data_file . " � ������ ������.");
        trigger_error("�� ���� ������� " . $user_data_file . " � ������ ������.", E_USER_ERROR);
        //in order not to damage guardian.dat we'll must to give up.
        exit;
    }

    $fp = fopen($data_path . "users/guardian.dat", "wb");
    if ($fp) {
        fwrite($fp, $t_id);
        fclose($fp);
    } else {
        AddToGuardianLog("�� ���� ������� " . $data_path . "users/guardian.dat � ������ ������.");
        trigger_error("�� ���� ������� " . $data_path . "users/guardian.dat � ������ ������.", E_USER_ERROR);
        exit;
    }

    AddToGuardianLog("���� ������ ������������� ���������������.");
}

function AddToGuardianLog($str)
{
    global $data_path;

    $fp_log = fopen($data_path . "users/guardian.log", "a+");
    if ($fp_log) {
        fwrite($fp_log, date("d-m-Y H:i:s") . " " . $str . "\n");
    } else {
        echo "Guardian error: cannot write to log-file <b>" . $data_path . "users/guardian.log" . "</b>!";
        trigger_error($str, E_USER_ERROR);
    }
    fclose($fp_log);
}

function cleanUpOldLogs()
{
    global $data_path;

    $log_path = $data_path . "logs/";
    $free_space = disk_free_space($data_path);

    if ($free_space > 10 * 1024 * 1024) return;

    $files_array = glob($log_path . "*.log");
    sort($files_array, SORT_STRING);

    for ($i = 0; $i < count($files_array); $i++) {
        @unlink($files_array[$i]);
        if ($free_space > 10 * 1024 * 1024) return;
    }
}
