<?php

require_once __DIR__ . "/../../../vendor/autoload.php";

include("check_session.php");

require_once __DIR__ . "/../inc_common.php";

include("header.php");

if (isset($user_ids)) {
    include($ld_engine_path . "admin_work.php");
    users_delete($user_ids);
    for ($i = 0; $i < count($user_ids); $i++) {
        echo "removing files for user id:" . $user_ids[$i] . "<br>";
        @unlink($file_path . "photos/" . floor($user_ids[$i] / 2000) . "/" . $user_ids[$i] . ".big.jpg");
        @unlink($file_path . "photos/" . floor($user_ids[$i] / 2000) . "/" . $user_ids[$i] . ".big.jpeg");
        @unlink($file_path . "photos/" . floor($user_ids[$i] / 2000) . "/" . $user_ids[$i] . ".big.gif");
        @unlink($file_path . "photos/" . floor($user_ids[$i] / 2000) . "/" . $user_ids[$i] . ".jpg");
        @unlink($file_path . "photos/" . floor($user_ids[$i] / 2000) . "/" . $user_ids[$i] . ".gif");
        @unlink($data_path . "board/" . floor($user_ids[$i] / 2000) . "/" . $user_ids[$i] . ".msg");
        @unlink($data_path . "users/" . floor($user_ids[$i] / 2000) . "/" . $user_ids[$i] . ".user");
        //VOC++
        @unlink($data_path . "user-board/" . floor($user_ids[$i] / 2000) . "/" . $user_ids[$i] . ".contrib");
        @unlink($data_path . "private-board/" . floor($user_ids[$i] / 2000) . "/" . $user_ids[$i] . ".msg");
        @unlink($data_path . "moder-board/" . floor($user_ids[$i] / 2000) . "/" . $user_ids[$i] . ".mod");
        @unlink($data_path . "user-viewed/" . floor($user_ids[$i] / 2000) . "/" . $user_ids[$i] . ".view");
        @unlink($data_path . "user-privates/" . floor($user_ids[$i] / 2000) . "/" . $user_ids[$i] . ".msg");
    }
}

?>
<center><span class=head>User(s) has been deleted!</center>
</body></html>