<?php

require_once __DIR__ . "/../../vendor/autoload.php";
require_once __DIR__ . "/inc_common.php";

include($engine_path . "users_get_list.php");

set_variable("surname");
set_variable("firstname");
set_variable("city");
set_variable("comments");
set_variable("email");
set_variable("url");
set_variable("icquin");
set_variable("day");
set_variable("month");
set_variable("year");
set_variable("sex");
set_variable("old_password");
set_variable("passwd1");
set_variable("passwd2");
set_variable("showGroup1");
set_variable("showGroup2");
set_variable("sm_del");
set_variable("big_del");
set_variable("enable_web_indicator");
set_variable("show_admin");
set_variable("show_for_moders");
set_variable("show_ip");
set_variable("use_old_paste");
set_variable("reduce_traffic");
set_variable("play_sound");
//security
set_variable("check_browser");
set_variable("check_cookie");
set_variable("limit_ips");
//video
set_variable("allow_webcam");
set_variable("webcam_ip");
set_variable("webcam_port");
//photo reiting
set_variable("allow_photo_reiting");
set_variable("allow_pass_check");

$allow_pass_check = intval($allow_pass_check);
if ($allow_pass_check) $allow_pass_check = true;
else $allow_pass_check = false;


$allow_photo_reiting = intval($allow_photo_reiting);
if ($allow_photo_reiting) $allow_photo_reiting = true;
else $allow_photo_reiting = false;

$allow_webcam = intval($allow_webcam);
if ($allow_webcam) $allow_webcam = true;
else $allow_webcam = false;

$webcam_ip = trim($webcam_ip);

if (!eregi("^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$", $webcam_ip)
    or strpos($webcam_ip, "127.0.") !== false
    or strpos($webcam_ip, "192.168.") !== false
) {
    $webcam_ip = "";
    $allow_webcam = false;
}

$webcam_port = intval($webcam_port);
if ($webcam_port <= 1024) {
    $webcam_port = 0;
    $allow_webcam = false;
}

$play_sound = intval($play_sound);
if ($play_sound) $play_sound = 1;
else $play_sound = 0;

$check_browser = intval($check_browser);
if ($check_browser) $check_browser = 1;
else $check_browser = 0;

$check_cookie = intval($check_cookie);
if ($check_cookie) $check_cookie = 1;
else $check_cookie = 0;

$show_admin = intval($show_admin);
if ($show_admin != 0 and $show_admin != 1) $show_admin = 0;

$show_for_moders = intval($show_for_moders);
if ($show_for_moders != 0 and $show_for_moders != 1) $show_for_moders = 0;

$use_old_paste = intval($use_old_paste);
if ($use_old_paste != 0 and $use_old_paste != 1) $use_old_paste = 0;

if (isset($HTTP_POST_FILES['small_photo']['name'])) $small_photo_name = $HTTP_POST_FILES['small_photo']['name'];
else $small_photo_name = "";
if (isset($HTTP_POST_FILES['small_photo']['tmp_name'])) $small_photo = $HTTP_POST_FILES['small_photo']['tmp_name'];
else $small_photo = "";
if (isset($HTTP_POST_FILES['small_photo']['size'])) $small_photo_size = $HTTP_POST_FILES['small_photo']['size'];
else $small_photo_size = "";
if (isset($HTTP_POST_FILES['big_photo']['name'])) $big_photo_name = $HTTP_POST_FILES['big_photo']['name'];
else $big_photo_name = "";
if (isset($HTTP_POST_FILES['big_photo']['tmp_name'])) $big_photo = $HTTP_POST_FILES['big_photo']['tmp_name'];
else $big_photo = "";
if (isset($HTTP_POST_FILES['big_photo']['size'])) $big_photo_size = $HTTP_POST_FILES['big_photo']['size'];
else $big_photo_size = "";

$fields_to_update = array();
$new_small_image = "";
if (!$exists) {
    $error_text = "$w_no_user";
    include($file_path . "designes/" . $design . "/error_page.php");
    exit;
}
if (!$is_regist_complete) exit;

include("inc_user_class.php");
include($ld_engine_path . "users_get_object.php");

//Patch for not valid user if session was not his =)
//added for Christmas Edition SE
$check_type = "user_info_update";

$info_message = "";
$passwd1 = str_replace("\t", "", $passwd1);
if ((!$passwd1) or ($passwd1 != $passwd2))
    $info_message .= "$w_pas_not_changed.<br>\n";
else {
    if ($md5_salt == "") {
        if ($current_user->password == md5($old_password)) {
            $info_message .= "$w_pas_changed<br>\n";
            $current_user->password = md5($passwd1);
        } else {
            $info_message .= "<b>$w_incorrect_password!</b><br>\n";
            $info_message .= "$w_pas_not_changed.<br>\n";
        }
    } else {
        $passSalt = md5($old_password);
        $passSalt = $md5_salt . $passSalt;
        $passSalt = md5($passSalt);

        if ($current_user->password == $passSalt or $current_user->password == md5($old_password)) {
            $info_message .= "$w_pas_changed<br>\n";

            $passSalt = md5($passwd1);
            $passSalt = $md5_salt . $passSalt;
            $passSalt = md5($passSalt);

            $current_user->password = $passSalt;
        } else {
            $info_message .= "<b>$w_incorrect_password!</b><br>\n";
            $info_message .= "$w_pas_not_changed.<br>\n";
        }
    }
}
if ($showGroup1 == "on") $current_user->show_group_1 = 1; else $current_user->show_group_1 = 0;
if ($showGroup2 == "on") $current_user->show_group_2 = 1; else $current_user->show_group_2 = 0;
$current_user->enable_web_indicator = ($enable_web_indicator == "on") ? 1 : 0;

$pic_name = "" . $is_regist . ".big.gif";
if (!file_exists($file_path . "photos/" . floor($is_regist / 2000) . "/$pic_name")) $pic_name = "";
if ($pic_name == "") {
    $pic_name = "" . $is_regist . ".big.jpg";
    if (!file_exists($file_path . "photos/" . floor($is_regist / 2000) . "/$pic_name")) $pic_name = "";
}
if ($pic_name == "") {
    $pic_name = "" . $is_regist . ".big.jpeg";
    if (!file_exists($file_path . "photos/" . floor($is_regist / 2000) . "/$pic_name")) $pic_name = "";
}
$big_picture = $pic_name;
$pic_name = "" . $is_regist . ".gif";
if (!file_exists($file_path . "photos/" . floor($is_regist / 2000) . "/$pic_name")) $pic_name = "";
if ($pic_name == "") {
    $pic_name = "" . $is_regist . ".jpg";
    if (!file_exists($file_path . "photos/" . floor($is_regist / 2000) . "/$pic_name")) $pic_name = "";
}
$small_picture = $pic_name;
$new_small_image = ($small_picture == "") ? "" : floor($is_regist / 2000) . "/" . $small_picture;

if (($big_photo_name != "" and $big_photo_name != "none") or $big_del == "on")
    if ($big_picture != "") unlink($file_path . "photos/" . floor($is_regist / 2000) . "/" . $big_picture);

if (($small_photo_name != "" and $small_photo_name != "none") or $sm_del == "on")
    if ($small_picture != "") unlink($file_path . "photos/" . floor($is_regist / 2000) . "/" . $small_picture);
$new_small_image = "";

#saving users photos
#not really good.
#I have also version which uses GD-library
#but it's not clear for me now, should I include it here or not.
#'cause it's not easy to determine which gd-functions are supported by ISP

if ($big_photo_name != "" and $big_photo_name != "none") {
    //echo "Step 2 inside<br>";
    $newFileLocation = "" . $is_regist;
    $newFileExtensions = strtolower(substr($big_photo_name, strrpos($big_photo_name, '.') + 1, strlen($big_photo_name)));
    $tmpName = $newFileLocation . ".big." . $newFileExtensions;
    $ok = 1;
    if ($big_photo_size > $max_photo_size && $max_photo_size > 0) {
        echo str_replace("~", $max_photo_size, str_replace("*", $big_photo_size, $w_too_big_photo)) . "<br>\n";
        $ok = 0;
    }

    list($roz_width, $roz_height, $type, $attr) = getimagesize($big_photo);
    if ($type != 1 and $type != 2) $ok = 0;

    if ($roz_width > $max_photo_width && $max_photo_width > 0) {
        echo str_replace("~", $max_photo_width, str_replace("*", $roz_width, $w_too_big_photo_width)) . "<br>\n";
        $ok = 0;
    }
    if ($roz_height > $max_photo_height && $max_photo_height > 0) {
        echo str_replace("~", $max_photo_height, str_replace("*", $roz_height, $w_too_big_photo_height)) . "<br>\n";
        $ok = 0;
    }
    //echo "Step 3 inside $ok, $newFileExtensions <br>";
    if ($ok)
        if ($newFileExtensions == "gif" or $newFileExtensions == "jpg" or $newFileExtensions == "jpeg") {
            move_uploaded_file($big_photo, $file_path . "photos/" . floor($is_regist / 2000) . "/$tmpName");
            chmod($file_path . "photos/" . floor($is_regist / 2000) . "/$tmpName", 0777);

            //DD addon for placing logos
            $gdSupport = false;
            if (function_exists("imagecreatefromgif") and $newFileExtensions == "gif") {
                $imgCanvas = imagecreatefromgif($file_path . "photos/" . floor($is_regist / 2000) . "/$tmpName");
                $imgCanvas_width = imagesx($imgCanvas);
                $imgCanvas_height = imagesy($imgCanvas);
                $gdSupport = true;
            }
            if (function_exists("imagecreatefromjpeg") and ($newFileExtensions == "jpg" or $newFileExtensions == "jpeg")) {
                $imgCanvas = imagecreatefromjpeg($file_path . "photos/" . floor($is_regist / 2000) . "/$tmpName");
                $imgCanvas_width = imagesx($imgCanvas);
                $imgCanvas_height = imagesy($imgCanvas);
                $gdSupport = true;
            }
            if (function_exists("imagecreatefrompng") and is_file($data_path . "copyright.png")) {
                $imgWatermark = imagecreatefrompng($data_path . "copyright.png");
                $imgWatermark_width = imagesx($imgWatermark);
                $imgWatermark_height = imagesy($imgWatermark);
                $gdSupport = true;

                if ($imgWatermark_width > $imgCanvas_width or
                    $imgWatermark_height > $imgCanvas_height) $gdSupport = false;

                $dest_x = $imgCanvas_width - $imgWatermark_width;
                $dest_y = $imgCanvas_height - $imgWatermark_height;
            } else {
                $gdSupport = false;
            }

            if ($gdSupport) {
                imagecopymerge($imgCanvas, $imgWatermark, $dest_x, $dest_y, 0, 0, $imgWatermark_width, $imgWatermark_height, 75);
                if (function_exists("imagefilter")) imagefilter($imgCanvas, IMG_FILTER_SMOOTH);
                imagedestroy($imgWatermark);

                if ($newFileExtensions == "gif" and function_exists("imagegif")) {
                    imagegif($imgCanvas, $file_path . "photos/" . floor($is_regist / 2000) . "/$tmpName");
                }
                if (function_exists("imagejpeg") and ($newFileExtensions == "jpg" or $newFileExtensions == "jpeg")) {
                    imagejpeg($imgCanvas, $file_path . "photos/" . floor($is_regist / 2000) . "/$tmpName", 100);
                }
                imagedestroy($imgCanvas);
            }

        }
}
if ($small_photo_name != "" and $small_photo_name != "none") {
    $newFileLocation = "" . $is_regist;
    $newFileExtensions = strtolower(substr($small_photo_name, strrpos($small_photo_name, '.') + 1, strlen($small_photo_name)));
    $tmpName = $newFileLocation . "." . $newFileExtensions;
    if ($small_photo_size > 4096) echo str_replace("~", "4096", str_replace("*", $small_photo_size, $w_too_big_avatar)) . "<br>\n";
    else {
        if ($newFileExtensions == "gif" or $newFileExtensions == "jpg") {
            move_uploaded_file($small_photo, $file_path . "photos/" . floor($is_regist / 2000) . "/$tmpName");
            @chmod($file_path . "photos/" . floor($is_regist / 2000) . "/$tmpName", 0644);
            $new_small_image = floor($is_regist / 2000) . "/" . $tmpName;
        }
    }
}

$fields_to_update[0][0] = USER_AVATAR;
$fields_to_update[0][1] = $new_small_image;
$fields_to_update[1][0] = USER_GENDER;
$fields_to_update[1][1] = intval($sex);

include($engine_path . "user_din_data_update.php");

$current_user->surname = htmlspecialchars($surname);
$current_user->firstname = htmlspecialchars($firstname);
$current_user->city = htmlspecialchars($city);
$current_user->about = htmlspecialchars($comments);
$current_user->about = str_replace("\n", "<br>", $current_user->about);

$current_user->url = "";
$url = "";

$current_user->icquin = htmlspecialchars($icquin);
$current_user->show_admin = $show_admin;
$current_user->show_for_moders = $show_for_moders;
$current_user->show_ip = $show_ip;
$current_user->use_old_paste = $use_old_paste;

if (intval($day) < 0 or intval($day) > 31) $day = 0;
if (intval($month) < 0 or intval($month) > 12) $month = 0;
if (intval($year) < 0 or intval($year) > 2000) $year = 0;
if (intval($sex) < 0 or intval($sex) > 2) $sex = 0;

$current_user->b_day = intval($day);
$current_user->b_month = intval($month);
$current_user->b_year = intval($year);
$current_user->sex = intval($sex);

$current_user->reduce_traffic = intval($reduce_traffic);

$current_user->play_sound = intval($play_sound);

$current_user->check_browser = $check_browser;
$current_user->check_cookie = $check_cookie;

$current_user->photo_take_part = $allow_photo_reiting;

if ($big_photo_name != "" and $big_photo_name != "none") {
    $current_user->photo_voted = array();
    $current_user->photo_voted_mark = array();
    $current_user->photo_reiting = 0;
}

if ($big_del == "on" or !$allow_photo_reiting) {
    $current_user->photo_voted = array();
    $current_user->photo_voted_mark = array();
    $current_user->photo_reiting = 0;
}


$limit_ips = trim($limit_ips);
$arr_ips = explode(";", $limit_ips);
$good_ips = array();

for ($i = 0; $i < count($arr_ips); $i++) {
    $test_ip = $arr_ips[$i];
    $test_ip = trim($test_ip);
    //may be subnetwork, delimited with :
    $test_ip_arr = explode(":", $test_ip);

    $good_ip = "";
    if (eregi("^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$", $test_ip_arr[0])) {
        $good_ip = $test_ip_arr[0];
        if (eregi("^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$", $test_ip_arr[1])) $good_ip = $good_ip . ":" . $test_ip_arr[1];
    } else $good_ip = "";
    if ($good_ip != "") $good_ips[] = $good_ip;
}

$good_ips = array_unique($good_ips);

$current_user->limit_ips = implode(";", $good_ips);

set_variable("font_face");
$font_face = intval($font_face);
if ($font_face < 0 or $font_face > count($fonts_arr) - 1) $font_face = 0;

set_variable("font_size");
$font_size = intval($font_size);
if ($font_size < 0 or $font_size > count($fonts_sizes_arr) - 1) $font_size = 2;

$current_user->plugin_info["font_face"] = $font_face;
$current_user->plugin_info["font_size"] = $font_size;

$current_user->allow_webcam = $allow_webcam;
$current_user->webcam_ip = $webcam_ip;
$current_user->webcam_port = $webcam_port;

$current_user->allow_pass_check = $allow_pass_check;

$User_UpdatePassword = true;
include($ld_engine_path . "user_info_update.php");

?>
<!doctype html>
<html>
<head></head>
<body>
<?php echo $info_message; ?>
<a href="user_info.php?session=<?php echo $session; ?>"><?php echo $w_about_me; ?></a>
</body>
</html>
