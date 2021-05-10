<?php

require_once __DIR__ . "/../../vendor/autoload.php";
require_once __DIR__ . "/inc_common.php";

include($ld_engine_path . "rooms_get_list.php");
include($engine_path . "users_get_list.php");

$messages_to_show = array();

include($ld_engine_path . "users_get_object.php");

set_variable("cause");
set_variable("toBan");
set_variable("kill_time");
set_variable("action");

if ($current_user->user_class < 1) {
    $error_text = "$w_no_admin_rights";
    include($file_path . "designes/" . $design . "/error_page.php");
    exit;
}

?>
<!doctype html>
<html>
<head></head>
<frameset rows="60,*" frameborder="no" framespacing="0" border="0" borderwidth="0">
    <frame src="<?php echo $chat_url . "admin_navi.php?session=" . $session; ?>" noresize scrolling="no" marginwidth="0"
           marginheight="0" name="voc_admin_navibar">
    <frame src="<?php echo $chat_url . "admin_work.php?session=" . $session; ?>" noresize scrolling="auto"
           marginwidth="0" marginheight="0" name="voc_admin_work">
</frameset>
</html>
