<?php

require_once __DIR__ . "/../../vendor/autoload.php";
require_once __DIR__ . "/inc_common.php";

include($engine_path . "users_get_list.php");

if (!$exists) {
    $error_text = "$w_no_user";
    include($file_path . "designes/" . $design . "/error_page.php");
    exit;
}

include("inc_user_class.php");
include($ld_engine_path . "users_get_object.php");

$pic_phrases = array();
$pic_urls = array();
include($ld_engine_path . "pictures.php");


include($file_path . "designes/" . $design . "/pictures.php");