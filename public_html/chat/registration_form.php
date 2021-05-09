<?php

require_once __DIR__ . "/../../vendor/autoload.php";
require_once __DIR__ . "/inc_common.php";

include($engine_path . "users_get_list.php");

set_variable("user_name");
set_variable("new_user_sex");
$new_user_sex = intval($new_user_sex);
set_variable("user_color");
$user_color = intval($user_color);
set_variable("room");
$room = intval($room);

set_variable("ref_id");
$ref_id = intval($ref_id);

if ($ref_id < 0) $ref_id = 0;

if (!intval($open_chat)) {
    $error_text = $w_roz_chat_closed;
    include($file_path . "designes/" . $design . "/error_page.php");
    exit;
}

include($file_path . "designes/" . $design . "/registration_form.php");
