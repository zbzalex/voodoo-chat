<?php
require_once("inc_common.php");
include($engine_path."users_get_list.php");
set_variable("id");
$id = intval($id);
set_variable("group");
$group = intval($group);

session_start();

if (!$exists) {
        $error_text = "$w_no_user";
        include($file_path."designes/".$design."/error_page.php");
        exit;
}
if(!$is_regist_complete) {
    $error_text = "<div align=center>$w_roz_only_for_club.</div>";
    include($file_path."designes/".$design."/error_page.php");
    exit;
}
include("inc_user_class.php");
include($ld_engine_path."users_get_object.php");

$board_operation = "view";
include($ld_engine_path."hidden_board_process_message.php");

include($file_path."designes/".$design."/board_view.php");
