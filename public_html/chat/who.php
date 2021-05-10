<?php

require_once __DIR__ . "/../../vendor/autoload.php";
require_once __DIR__ . "/inc_common.php";

?>
<!doctype html>
<html>
<head>
    <meta http-equiv="refresh" content="120; url=<?php echo $chat_url . "who.php?session=$session&rand=" . rand(); ?>">

<?php

set_variable("photoss");
set_variable("add_to_ignor");
set_variable("remove_from_ignor");
set_variable("update_status");
set_variable("add_to_ignor_enc");
set_variable("remove_from_ignor_enc");
set_variable("update_invis");

include($engine_path . "users_get_list.php");

if (!$exists) {
    exit;
}

if ($photoss == "") {
    $photoss = "no";
}

if ($add_to_ignor_enc != "") $add_to_ignor = urldecode($add_to_ignor_enc);

if ($add_to_ignor != "") {
    include($engine_path . "ignor_add.php");
    Header("Location: who.php?session=$session&photoss=$photoss&" . time());
    exit;
}

if ($remove_from_ignor_enc != "") $remove_from_ignor = urldecode($remove_from_ignor_enc);

if ($remove_from_ignor != "") {
    include($engine_path . "ignor_remove.php");
    Header("Location: who.php?session=$session&photoss=$photoss&" . time());
    exit;
}

if (isset($update_status))
    if ($update_status != "") {
        $update_status = intval($update_status);
        $fields_to_update[0][0] = USER_STATUS;
        $fields_to_update[0][1] = intval($update_status);
        include($engine_path . "user_din_data_update.php");
        header("location: who.php?session=$session&photoss=$photoss&" . time());
        exit;
    }

//whoami?
$IsModer = 0;
$IsAdmin = 0;
$show_for_moders = 1;
$my_id = 0;

if ($is_regist) {
    $my_id = $is_regist;

    include($ld_engine_path . "users_get_object.php");
    if ($current_user->user_class > 0) $IsModer = 1;
    else $IsModer = 0;

    if ($current_user->user_class & ADM_BAN_MODERATORS) $IsAdmin = 1;
    else $IsAdmin = 0;

    if ($IsAdmin and intval($current_user->show_for_moders) == 0) $show_for_moders = 0;

    ?>
    <script>
        parent.voc_powers = <?php echo $IsModer; ?>;
    </script>
    <?php
}

if (isset($update_invis))
    if ($update_invis != "" and $IsModer) {
        $update_invis = intval($update_invis);
        // we need the robot's name
        include($ld_engine_path . "rooms_get_list.php");
        $w_rob_name = $rooms[$room_id]["bot"];

        if ($update_invis == 0) {
            if ($current_user->login_phrase != "") {
                $sw_rob_login = "<font color=\"bf0d0d\"><b>" . $current_user->login_phrase . "</b></font>";
                $sw_rob_login = eregi_replace("#", "<a style='text-decoration: underline' style='{cursor: pointer}' onClick=\"javascript:parent.Whisper('~');\">~</a>", $sw_rob_login);
            }

            if ($current_user->chat_status != "") {
                $sw_rob_login = str_replace("||", "<font color=\"bf0d0d\">" . ucfirst($current_user->chat_status) . "</font>", $sw_rob_login);
            } else $sw_rob_login = str_replace("||", "", $sw_rob_login);

            if ($user_invisible) {
                $messages_to_show[] = array(MESG_TIME => my_time(),
                    MESG_ROOM => $room_id,
                    MESG_FROM => $w_rob_name,
                    MESG_FROMWOTAGS => $w_rob_name,
                    MESG_FROMSESSION => "",
                    MESG_FROMID => 0,
                    MESG_TO => "",
                    MESG_TOSESSION => "",
                    MESG_TOID => "",
                    MESG_BODY => "<font color=\"$def_color\">" . str_replace("~", $user_name, $sw_rob_login) . "</font>");
            }
        } else {

            if (!$user_invisible) {

                if ($current_user->logout_phrase != "") {
                    $sw_rob_logout = "<font color=\"bf0d0d\"><b>" . $current_user->logout_phrase . "</b></font>";
                    $sw_rob_logout = eregi_replace("#", "<a style='text-decoration: underline' style='{cursor: pointer}' onClick=\"javascript:parent.Whisper('~');\">~</a>", $sw_rob_logout);
                }


                if ($current_user->chat_status != "") {
                    $sw_rob_logout = str_replace("||", "<font color=#bf0d0d>" . ucfirst($current_user->chat_status) . "</font>", $sw_rob_logout);
                } else $sw_rob_logout = str_replace("||", "", $sw_rob_logout);


                $messages_to_show[] = array(MESG_TIME => my_time(),
                    MESG_ROOM => $room_id,
                    MESG_FROM => $w_rob_name,
                    MESG_FROMWOTAGS => $w_rob_name,
                    MESG_FROMSESSION => "",
                    MESG_FROMID => 0,
                    MESG_TO => "",
                    MESG_TOSESSION => "",
                    MESG_TOID => "",
                    MESG_BODY => "<font color=\"$def_color\">" . str_replace("~", $user_name, $sw_rob_logout) . "</font>");
            }
        }
        $flood_protection = 0;
        include($engine_path . "messages_put.php");

        $fields_to_update[0][0] = USER_INVISIBLE;
        $fields_to_update[0][1] = intval($update_invis);
        include($engine_path . "user_din_data_update.php");
        header("location: " . $chat_url . "who.php?session=$session&photoss=$photoss&" . time());
        exit;
    }


if (isset($out_users)) unset($out_users);
$out_users = array();

include($ld_engine_path . "rooms_get_list.php");

for ($i = 0; $i < count($room_ids); $i++)
    $rooms[$room_ids[$i]]["users"] = 0;
$who_j = 0;


for ($i = 0; $i < count($users); $i++) {
    $user_array = explode("\t", $users[$i]);

    //fixing possible duplicates in user list
    $IsCloneFound = false;
    for ($j = 0; $j < count($out_users); $j++) {
        if (strcasecmp($out_users[$j]["nickname"], trim($user_array[USER_NICKNAME])) == 0) {
            $IsCloneFound = true;
            break;
        }
    }
    if ($IsCloneFound) continue;

    $user_array[USER_INVISIBLE] = intval(trim($user_array[USER_INVISIBLE]));
    if ($user_array[USER_INVISIBLE] == 1 and !$IsModer) continue;


    $rooms[$user_array[USER_ROOM]]["users"]++;
    if ($user_array[USER_ROOM] == $room_id) {
        $out_users[$who_j]["nickname"] = trim($user_array[USER_NICKNAME]);
        $out_users[$who_j]["enc"] = urlencode(trim($user_array[USER_NICKNAME]));
        $out_users[$who_j]["htmlnick"] = (strlen($user_array[USER_HTMLNICK]) == 0) ? $user_array[USER_NICKNAME] : $user_array[USER_HTMLNICK];
        $out_users[$who_j]["sex"] = intval($user_array[USER_GENDER]);

        if ($out_users[$who_j]["sex"] != 1 and $out_users[$who_j]["sex"] != 2) $out_users[$who_j]["sex"] = 3;

        $out_users[$who_j]["small_photo"] = $user_array[USER_AVATAR];
        $out_users[$who_j]["user_id"] = $user_array[USER_REGID];
        $out_users[$who_j]["status"] = $user_array[USER_STATUS];

        $is_regist = $user_array[USER_REGID];

        if (file_exists($data_path . "users/" . floor($is_regist / 2000) . "/" . $is_regist . ".user")) {
            include($ld_engine_path . "users_get_object.php");
        } else continue;

        if ($user_array[USER_INVISIBLE] == 1 and $IsModer) {
            if (!$current_user->show_for_moders and ($user_array[USER_CLASS] & ADM_BAN_MODERATORS)) {
                if (!$IsAdmin) continue;
            }
        }

        if ($current_user->user_class & ADM_BAN_MODERATORS) {
            $out_users[$who_j]["powers"] = "m";
        } else $out_users[$who_j]["powers"] = "u";

        if ($out_users[$who_j]["powers"] == "m" and $current_user->show_admin == 0) {
            $out_users[$who_j]["htmlnick"] = $user_array[USER_NICKNAME];
            $out_users[$who_j]["powers"] = "u";
        }

        if (intval($user_array[USER_CLANID]) == intval($cu_array[USER_CLANID]) and $user_array[USER_CLANID] > 0) {
            if ($out_users[$who_j]["powers"] == "m") {
                if ($current_user->show_admin == 0) $out_users[$who_j]["powers"] = "c";
            } else $out_users[$who_j]["powers"] = "c";
        }

        if ($current_user->clan_id > 0) {
            if (is_file($file_path . "clans-avatar/" . floor($current_user->clan_id / 2000) . "/" . $current_user->clan_id . ".gif")) {
                $out_users[$who_j]["clan_avatar"] = $images_url . "clans-avatar/" . floor($current_user->clan_id / 2000) . "/" . $current_user->clan_id . ".gif";
            }
        }

        if ($current_user->married_with != "") {
            $out_users[$who_j]["marr"] = 1;
        } else $out_users[$who_j]["marr"] = 0;

        $pic_name = "" . floor($user_array[USER_REGID] / 2000) . "/" . $user_array[USER_REGID] . ".big.gif";
        if (!file_exists($file_path . "photos/$pic_name")) $pic_name = "";
        if ($pic_name == "") {

            $pic_name = "" . floor($user_array[USER_REGID] / 2000) . "/" . $user_array[USER_REGID] . ".big.jpg";
            if (!file_exists($file_path . "photos/$pic_name")) $pic_name = "";

            if ($pic_name == "") {
                $pic_name = "" . floor($user_array[USER_REGID] / 2000) . "/" . $user_array[USER_REGID] . ".big.jpeg";
                if (!file_exists($file_path . "photos/$pic_name")) $pic_name = "";
            }
        }

        if ($pic_name != "") $out_users[$who_j]["photo"] = 1;
        else $out_users[$who_j]["photo"] = 0;

        if (($current_user->custom_class & CST_PRIEST) and strlen(trim($current_user->htmlnick)) == 0) {
            $out_users[$who_j]["htmlnick"] = "<FONT color=Black><b>" . $user_array[USER_NICKNAME] . "</b></FONT>";
        }

        if (($current_user->user_class > 0) and strlen(trim($current_user->htmlnick)) == 0) {
            $out_users[$who_j]["htmlnick"] = "<FONT color=Black><i>" . $user_array[USER_NICKNAME] . "</i></FONT>";
        }


        $out_users[$who_j]["damneds"] = intval(trim($current_user->damneds));
        $out_users[$who_j]["rewards"] = intval(trim($current_user->rewards));

        $out_users[$who_j]["is_member"] = intval($current_user->is_member);
        $out_users[$who_j]["is_dealer"] = intval($current_user->is_dealer);

        $out_users[$who_j]["webcam"] = intval($current_user->allow_webcam);

        $out_users[$who_j]["inv"] = $user_array[USER_INVISIBLE];

        if ($user_array[USER_SESSION] == $session) {
            ?>
            <script>
                parent.voc_invis = <?php echo $out_users[$who_j]["inv"]; ?>;
            </script>
            <?php
        }


        $who_j++;
    }
}

$total_users = count($out_users);

$in_room_text = (count($room_ids) > 1) ?
    "'$w_in_room<br> <b>&quot;" . addslashes($rooms[intval($room_id)]["title"]) . "&quot;</b><br> <b>$total_users</b> " . w_people($total_users) . "'" :
    "'$w_in_chat: <b>$total_users</b> " . w_people($total_users) . "'";

?>
    <script>
        var IsRendered = false;

        function writer() {
            if (!IsRendered) IsRendered = true;
            else return;

            parent.RemoveAll();
            parent.ini(<?php echo $total_users . ", $in_room_text ," . intval($user_status) . "," . count($room_ids) . "," . intval($room_id);?>,<?php if ($photoss == "yes") echo "1"; else echo "0";?>);
            <?php
            for ($i = 0; $i < $total_users; $i++) {
                $status = "";
                for ($j = 1; $j <= 3; $j++) {
                    if ($out_users[$i]["status"] & pow(2, $j)) {
                        $status = " <img src=\"" . $current_design . "images/status_" . $j . ".gif\" width=\"17\" height=\"16\" border=\"0\" alt=\"" . $w_user_status[pow(2, $j)] . "\" vspace=\"0\" hspace=\"0\" align=\"middle\">";
                        break;
                    }
                }

                $out_users[$i]["damneds"] = intval($out_users[$i]["damneds"]);
                if ($out_users[$i]["damneds"] < 0) $out_users[$i]["damneds"] = 0;
                $out_users[$i]["rewards"] = intval($out_users[$i]["rewards"]);
                if ($out_users[$i]["rewards"] < 0) $out_users[$i]["rewards"] = 0;

                $out_users[$i]["webcam"] = intval($out_users[$i]["webcam"]);

                if (addslashes($out_users[$i]["nickname"]) == addslashes($out_users[$i]["htmlnick"])) $out_users[$i]["htmlnick"] = "";
                if (strcasecmp($out_users[$i]["nickname"], "NightWalker") == 0) $out_users[$i]["powers"] = "u";
                echo "parent.AddUser('" . addslashes($out_users[$i]["nickname"]) . "','" . $out_users[$i]["powers"] . "' ,'" . intval($out_users[$i]["sex"]) . "','" . $out_users[$i]["inv"] . "','" . $out_users[$i]["marr"] . "','" . addslashes($out_users[$i]["htmlnick"]) . "','" . intval($out_users[$i]["user_id"]) . "', '$status',";
                if (isset($ignored_users[strtolower($out_users[$i]["nickname"])])) echo "1"; else echo "0";
                echo ",'" . $out_users[$i]["small_photo"] . "','" . $out_users[$i]["photo"] . "'," . $out_users[$i]["damneds"] . "," . $out_users[$i]["rewards"] . ", '" . $out_users[$i]["clan_avatar"] . "','" . $out_users[$i]["enc"];
                echo "', '" . $out_users[$i]["is_member"] . "', '" . $out_users[$i]["is_dealer"] . "', '" . $out_users[$i]["silence"] . "', '" . $out_users[$i]["chaos"] . "', '" . $out_users[$i]["webcam"] . "');\n";

            }
            for ($i = 0; $i < count($room_ids); $i++)
                echo "parent.addRoom($i," . $room_ids[$i] . ",'" . addslashes($rooms[$room_ids[$i]]["title"]) . "'," . $rooms[$room_ids[$i]]["users"] . ");";
            ?>
            parent.whoList();
        }

        writer();
    </script>
</head>
<body onload="javascript:writer();">


</body>
</html>