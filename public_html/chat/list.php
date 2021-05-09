<?php

require_once __DIR__ . "/../../vendor/autoload.php";
require_once __DIR__ . "/inc_common.php";

include($engine_path . "users_get_list.php");

$out_users = "";
for ($i = 0; $i < count($users); $i++) {
    $data = explode("\t", $users[$i]);
    if (intval(trim($data[USER_INVISIBLE])) != 1) $out_users .= $data[0] . ";";
}

echo $out_users;