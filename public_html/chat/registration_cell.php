<?php

require_once __DIR__ . "/../../vendor/autoload.php";
require_once __DIR__ . "/inc_common.php";

#for determining design and user_name
include($engine_path . "users_get_list.php");

set_variable("user_name");
$user_name = htmlspecialchars(trim($user_name));

if (ereg("[^" . $nick_available_chars . "]", $user_name)) {
    $error_text = "$w_incorrect_nick (" . $user_name . ">$w_try_again</a>";
    include($file_path . "designes/" . $design . "/error_page.php");
    exit;
}


set_variable("new_user_sex");
$new_user_sex = intval($new_user_sex);
set_variable("user_color");
$user_color = intval($user_color);
set_variable("room");
$room = intval($room);

if (!intval($open_chat)) {
    $error_text = $w_roz_chat_closed;
    include($file_path . "designes/" . $design . "/error_page.php");
    exit;
}

include($file_path . "designes/" . $design . "/registration_cell.php");