<?php

require_once __DIR__ . "/../../vendor/autoload.php";
require_once __DIR__ . "/inc_common.php";

include($engine_path . "users_get_list.php");

if (!$is_regist_complete) {
    $session = "";
}

if (!isset($user_id)) {
    set_variable("user_id");
}

$user_id = intval($user_id);

#fake for including files, without functions
$is_regist = $user_id;
if ($is_regist) {
    include("inc_user_class.php");
    include($ld_engine_path . "users_get_object.php");
} else {
    $error_text = str_replace("~", $user_id, $w_search_no_found);
    include($file_path . "designes/" . $design . "/error_page.php");
    exit;
}

$pic_name = "" . floor($is_regist / 2000) . "/" . $is_regist . ".big.gif";
if (!file_exists($file_path . "photos/$pic_name")) $pic_name = "";

if ($pic_name == "") {

    $pic_name = "" . floor($is_regist / 2000) . "/" . $is_regist . ".big.jpg";
    if (!file_exists($file_path . "photos/$pic_name")) $pic_name = "";

    if ($pic_name == "") {
        $pic_name = "" . floor($is_regist / 2000) . "/" . $is_regist . ".big.jpeg";
        if (!file_exists($file_path . "photos/$pic_name")) $pic_name = "";
    }

}

$sex = $current_user->sex;
$sexStr = $w_unknown;
switch ($sex) {
    case 1:
        $sexStr = $w_male;
        break;
    case 2:
        $sexStr = $w_female;
        break;
}

?>

<!doctype html>
<html>
<head>
    <title><?php echo $current_user->nickname; ?> -- <?= $w_title ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
    <link rel="STYLESHEET" type="text/css" href="<?php echo $current_design; ?>style.css">
    <frameset rows="97,*" FRAMEBORDER="0" BORDER="0" FRAMESPACING="0">
        <frame src="<?php echo $current_design; ?>profile_top.php?session=<?php echo $session; ?>&user_id=<?php echo $user_id; ?>"
               scrolling=NO NORESIZE FRAMEBORDER="0" BORDER="0" FRAMESPACING="0" MARGINWIDTH="0" MARGINHEIGHT="0">
        <frameset cols="350,*" FRAMEBORDER="0" BORDER="0" FRAMESPACING="0">
            <frame src="<?php echo $current_design; ?>profile_photo.php?session=<?php echo $session; ?>&user_id=<?php echo $user_id; ?>"
                   scrolling=NO NORESIZE FRAMEBORDER="0" BORDER="0" FRAMESPACING="0" MARGINWIDTH="0" MARGINHEIGHT="0">
            <frame src="<?php echo $current_design; ?>profile_content.php?session=<?php echo $session; ?>&user_id=<?php echo $user_id; ?>"
                   scrolling=yes FRAMEBORDER="0" BORDER="0" FRAMESPACING="0" MARGINWIDTH="0" MARGINHEIGHT="0">
            </framset>
        </frameset>
    </frameset>
</head>
</html>
