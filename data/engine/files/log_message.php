<?php
function log_clearing($to_ban, $room, $author)
{
    global $data_path;

    $messages_file = $data_path . "messages.dat";
    $fp_log = fopen($messages_file, "r+");
    flock($fp_log, LOCK_EX);
    if (!$fp_log) {
        echo "<script>alert('Could not lock [$messages_file] for writing. Please, check permissions!');</script>";
        return;
    }

    unset($tmp_messages);
    $tmp_messages = array();
    $chk_msg = array();

    fseek($fp_log, 0);

    while ($ttt = fgets($fp_log, 16384)) {
        if (strlen($ttt) < 7) continue;
        $chk_msg = explode("\t", trim($ttt));

        if (strcasecmp($chk_msg[MESG_FROMWOTAGS], $to_ban) != 0) {
            $tmp_messages[] = implode("\t", $chk_msg);
        } else {
            if (trim($chk_msg[MESG_TO]) != "" or intval(trim($chk_msg[MESG_ROOM])) != $room) $tmp_messages[] = implode("\t", $chk_msg);
        }
    }

    fseek($fp_log, 0);
    ftruncate($fp_log, 0);
    foreach ($tmp_messages as $tmp_msg) fwrite($fp_log, $tmp_msg . "\n");

    flock($fp_log, LOCK_UN);
    fclose($fp_log);
}


function log_ban($admin, $to_ban, $ip_to_ban, $room, $reason)
{
    global $data_path, $HTTP_SERVER_VARS;
    $REMOTE_ADDR = "";
    if (isset($HTTP_SERVER_VARS['REMOTE_ADDR'])) $REMOTE_ADDR = $HTTP_SERVER_VARS['REMOTE_ADDR'];
    $fp_log = fopen($data_path . "logs/" . date("Y-m-d", my_time()) . ".log", "a+");
    flock($fp_log, LOCK_EX);
    fwrite($fp_log, date("H:i:s", my_time()) . "\t" . "[BAN]\t" .
        $REMOTE_ADDR . "\t" .
        $admin . "\troom " . $room . "\t" .
        $to_ban . "(" . $ip_to_ban . ") " . $reason . "\n");
    fflush($fp_log);
    flock($fp_log, LOCK_UN);
    fclose($fp_log);
}

function log_unban($admin, $to_unban)
{
    global $data_path, $HTTP_SERVER_VARS;
    $REMOTE_ADDR = "";
    if (isset($HTTP_SERVER_VARS['REMOTE_ADDR'])) $REMOTE_ADDR = $HTTP_SERVER_VARS['REMOTE_ADDR'];
    $fp_log = fopen($data_path . "logs/" . date("Y-m-d", my_time()) . ".log", "a+");
    flock($fp_log, LOCK_EX);
    fwrite($fp_log, date("H:i:s", my_time()) . "\t" . "[UNBAN]\t" .
        $REMOTE_ADDR . "\t" .
        $admin . "\troom N/A\t" .
        $to_unban . "\n");
    fflush($fp_log);
    flock($fp_log, LOCK_UN);
    fclose($fp_log);
}

function log_message()
{

}
