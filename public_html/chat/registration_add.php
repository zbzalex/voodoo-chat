<?php

require_once __DIR__ . "/../../vendor/autoload.php";
require_once __DIR__ . "/inc_common.php";
require_once __DIR__ . "/inc_to_canon_nick.php";

include($engine_path . "users_get_list.php");

set_variable("new_user_name");
set_variable("passwd1");
set_variable("passwd2");
set_variable("new_user_sex");
set_variable("agreed");

set_variable("user_color");
$user_color = intval($user_color);
set_variable("room");
$room = intval($room);

set_variable("ref_id");
$ref_id = intval($ref_id);

if ($ref_id < 0) $ref_id = 0;

$passwd1 = str_replace("\t", "", $passwd1);
$passwd2 = str_replace("\t", "", $passwd2);

if ((strlen($new_user_name) < $nick_min_length) or (strlen($new_user_name) > $nick_max_length)) {
    $error_text = "$w_incorrect_nick<br><a href=\"registration_form.php?session=$session\">$w_try_again</a>";
    include($file_path . "designes/" . $design . "/error_page.php");
    exit;
}

if (ereg("[^" . $nick_available_chars . "]", $new_user_name)) {
    $error_text = "$w_incorrect_nick<br><a href=\"registration_form.php?session=$session\">$w_try_again</a>";
    include($file_path . "designes/" . $design . "/error_page.php");
    exit;
}

if (strcasecmp($sw_usr_all_link, $new_user_name) == 0 or
    strcasecmp($sw_usr_adm_link, $new_user_name) == 0 or
    strcasecmp($sw_usr_boys_link, $new_user_name) == 0 or
    strcasecmp($sw_usr_girls_link, $new_user_name) == 0 or
    strcasecmp($sw_usr_they_link, $new_user_name) == 0 or
    strcasecmp($sw_usr_clan_link, $new_user_name) == 0 or
    strcasecmp($sw_usr_shaman_link, $new_user_name) == 0 or
    strcasecmp("&CMD", $new_user_name) == 0) {
    $error_text = "$w_incorrect_nick<br><a href=\"registration_form.php?session=$session\">$w_try_again</a>";
    include($file_path . "designes/" . $design . "/error_page.php");
    exit;
}
if (strlen($passwd1) < 3) {
    $error_text = $w_enter_password . "<a href=\"registration_form.php?session=$session\">$w_try_again</a>";
    include($file_path . "designes/" . $design . "/error_page.php");
    exit;
}
if ($passwd1 != $passwd2) {
    $error_text = $w_password_mismatch . "<a href=\"registration_form.php?session=$session\">$w_try_again</a>";
    include($file_path . "designes/" . $design . "/error_page.php");
    exit;
}
if ($agreed != 1) {
    $error_text = "<a href=\"registration_form.php?session=$session\">$w_try_again</a>";
    include($file_path . "designes/" . $design . "/error_page.php");
    exit;
}

$pass_to_voc = $passwd1;

if ($md5_salt != "") {
    $passSalt = md5($passwd1);
    $passSalt = $md5_salt . $passSalt;
    $passSalt = md5($passSalt);
    $passwd1 = $passSalt;
} else $passwd1 = md5($passwd1);

$passwd2 = $passwd2;
if ($registration_mailconfirm) {
    set_variable("new_user_mail");
    include($ld_engine_path . "registration_mail.php");
    list($usec, $sec) = explode(' ', microtime());
    srand((float)$sec + ((float)$usec * 100000));

    $regkey = md5(uniqid(rand()));

//    regmail_add($new_user_name, $passwd1, $new_user_mail, $regkey);
//    if (!mail($new_user_mail, "registration at " . $w_title,
//        str_replace("~", $new_user_name, str_replace("*", $w_title, str_replace("#", $chat_url . "registration_activate.php?regkey=" . $regkey, $w_regmail_body))),
//        "From: " . str_replace("\\@", "@", $admin_mail) . "\n" .
//        "Content-type: text/plain; " . (($charset != "") ? "charset=" . $charset : "") . "\n" .
//        "Content-Transfer-Encoding: 8bit"
//    ))
//        trigger_error("Cannot send mail with activation code", E_USER_ERROR);
    $html_to_out = $w_regmail_sent;
    require($file_path . "designes/" . $design . "/output_page.php");
    exit;
}
include($ld_engine_path . "registration_add.php");

include($file_path . "designes/" . $design . "/registration_add.php");
