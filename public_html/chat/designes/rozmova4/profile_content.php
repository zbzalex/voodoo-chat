<?php

define("EDIT_LIMIT", 10);

require_once __DIR__ . "/../../../../vendor/autoload.php";
require_once __DIR__ . "/../../inc_common.php";

include($engine_path . "users_get_list.php");

set_variable("page");
$page = intval($page);

$IsModer = false;
if ($cu_array[USER_CLASS] > 0) $IsModer = true;
$IsAdmin = false;
if ($cu_array[USER_CLASS] & ADM_BAN_MODERATORS) $IsAdmin = true;

if (!$is_regist_complete) $session = "";
if (!$exists) $session = "";
else {
    $is_regist_old = $is_regist;
}

set_variable("user_id");
$user_id = intval($user_id);

if ($user_id == $is_regist)
    $IsMyProfile = true;
else
    $IsMyProfile = false;


include($file_path . "inc_user_class.php");
include($ld_engine_path . "users_get_object.php");

$userPoints = $current_user->points;

if ($current_user->registered) {
    if ($current_user->is_member) $IsMember = true;
    else $IsMember = false;
} else $IsMember = false;

$is_regist = $user_id;
if ($is_regist) {
    include($ld_engine_path . "users_get_object.php");
} else {
    $error_text = str_replace("~", "", $w_search_no_found);
    include($file_path . "designes/" . $design . "/error_page.php");
    exit;
}

//actions
set_variable("act");

switch ($act) {
    case "make_member":
        if (!$exists or !$is_regist_complete or !$IsMember) {
            $error_text = "$w_no_user";
            include($file_path . "designes/" . $design . "/error_page.php");
            exit;
        }

        if (!$current_user->is_member and $current_user->registered and $IsMember and $IsModer) {
            $current_user->is_member = true;
            $current_user->membered_by = $user_name;
        }

        include($ld_engine_path . "user_info_update.php");
        break;

    case "add_personal":
        if ($IsModer) {

            set_variable("moder_message");
            set_variable("moder_user_id");

            $moder_user_id = intval($moder_user_id);

            if (!$exists) {
                $error_text = "$w_no_user";
                include($file_path . "designes/" . $design . "/error_page.php");
                exit;
            }

            $moder_message = htmlspecialchars($moder_message);
            $moder_message = str_replace("\n", "", $moder_message);
            $moder_message = str_replace("\r", "", $moder_message);
            $moder_message = str_replace("\t", " ", $moder_message);
            $moder_message = str_replace("  ", " &nbsp;", $moder_message);

            $moder_message = fixup_contributions($moder_message);
            if (strlen($moder_message) > 256) $moder_message = substr($moder_message, 0, 256);

            include($ld_engine_path . "user_log.php");
            WriteToUserLog($moder_message, $is_regist, $user_name);
        }
        break;
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

include($file_path . "designes/" . $design . "/common_title.php");
include($file_path . "designes/" . $design . "/common_browser_detect.php");

$current_user->show_group_1 = 1;
$current_user->show_group_2 = 1;

?>
<!doctype html>
<html>
<head>
    <style>
        * {
            padding: 0;
            margin : 0;
            box-sizing: border-box;
        }
        td {
            font-family: Georgia, Garamond, Verdana, Tahoma, Arial;
            font-size: 12pt;
        }
    </style>
    <script src="<?= $current_design ?>tooltip.js"></script>
</head>
<body onload="initToolTips('SPAN','IMG', 'DIV');">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td>
            <table border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <?php if ($current_user->is_member) { ?>
                        <td width="125" align="center">
                            <img src="<?= $current_design ?>main/vip_big.jpg">
                        </td>
                    <?php } ?>
                    <td width="100%" align="center">
                        <table align="center" border="0" cellpadding="0" cellspacing="0">
                            <!-- userinfo table -->
                            <tr>
                                <td colspan="2">&nbsp;</td>
                            </tr>
                            <?php if ($current_user->show_group_1 == 1) { ?>
                                <tr>
                                    <td align=right><?php echo $w_name; ?>:</td>
                                    <td>
                                        <font color="#bf0d0d"><b>&nbsp;<?php echo $current_user->firstname; ?></b></font>
                                    </td>
                                </tr>
                                <tr>
                                    <td align=right><?php echo $w_surname; ?>:</font></td>
                                    <td><font color="#bf0d0d"><b>&nbsp;<?php echo $current_user->surname; ?></b></font>
                                    </td>
                                </tr>
                                <tr>
                                    <td align=right><?php echo $w_gender; ?>:</td>
                                    <td><font color="#bf0d0d"><b>&nbsp;<?php echo $sexStr; ?></b></font></td>
                                </tr>
                                <tr>
                                    <td align=right><?php echo $w_birthday; ?>:</td>
                                    <td>
                                        <font color="#bf0d0d"><b>&nbsp;<?php echo $current_user->b_day . "." . $current_user->b_month . "." . $current_user->b_year; ?></b></font>
                                    </td>
                                </tr>
                                <tr>
                                    <td align=right><?php echo $w_city; ?>:</td>
                                    <td><font color="#bf0d0d"><b>&nbsp;<?php echo $current_user->city; ?></b></font>
                                    </td>
                                </tr>
                            <?php } ?>
                            <?php
                            if ($current_user->is_member == false
                                and $current_user->registered == true
                                and $IsMember and $IsModer) { ?>
                                <tr>
                                    <td colspan="2">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td align="center" colspan="2">
                                        <form action="<?= $current_design ?>profile_content.php" method="POST">
                                            <input type="hidden" name="session" value="<?= $session ?>">
                                            <input type="hidden" name="user_id" value="<?= intval($user_id) ?>">
                                            <input type="hidden" name="act" value="make_member">
                                            <input type="Submit" class="input_button" value="<?= $w_grant_access ?>">
                                        </form>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">&nbsp;</td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td colspan="2">&nbsp;</td>
                            </tr>
                        </table>
                    </td>
                    <td width="200" valign="top"><br>
                        <?php
                        include_once($file_path . "designes/" . $design . "/zodiac.php");
                        $zpic = \VOC\util\Zodiac::getZodiac($current_user->b_day, $current_user->b_month);
                        echo "<img src=\"" . $current_design . "zodiac/$zpic\" width=\"200\" height=\"150\">";
                        ?>
                    </td>
                </tr>

            </table>
        </td>
    </tr>
    <?php

    //ban check
    include($file_path . "inc_to_canon_nick.php");
    include($ld_engine_path . "ban_check.php");

    $banStr = "";
    $LbanType = "";
    $LbanUntil = "";
    $b_users = get_all_bans();


    for ($i = 0; $i < count($b_users); $i++) {
        if ((strcasecmp("un|" . to_canon_nick($current_user->nickname), $b_users[$i]["who"]) == 0)) {
            $LbanType = "NICK";
            $LbanUntil = date("d.m.Y H:i:s", intval(intval($b_users[$i]["until"]) + $time_offset * 3600));
            break;
        } else if ((strcasecmp("ip|" . $current_user->IP, $b_users[$i]["who"]) == 0)) {
            $LbanType = "IP";
            $LbanUntil = date("d.m.Y H:i:s", intval(intval($b_users[$i]["until"]) + $time_offset * 3600));
            break;
        } else if ((strcasecmp("ch|" . $current_user->cookie_hash, $b_users[$i]["who"]) == 0)) {
            $LbanType = "COOKIE";
            $LbanUntil = date("d.m.Y H:i:s", intval(intval($b_users[$i]["until"]) + $time_offset * 3600));
            break;
        } else if ((strcasecmp("bh|" . $current_user->browser_hash, $b_users[$i]["who"]) == 0)) {
            $LbanType = $w_roz_browser_id;
            $LbanUntil = date("d.m.Y H:i:s", intval(intval($b_users[$i]["until"]) + $time_offset * 3600));
            break;
        } else if ((strcasecmp("sn|" . substr($current_user->IP, 0, strrpos($current_user->IP, ".")), $b_users[$i]["who"]) == 0)) {
            $LbanType = "NETWORK";
            $LbanUntil = date("d.m.Y H:i:s", intval(intval($b_users[$i]["until"]) + $time_offset * 3600));
            break;
        }
    }

    if ($LbanType != "") {
        $banStr = str_replace("#", $LbanType, $w_roz_user_banned);
        $banStr = str_replace("*", $LbanUntil, $banStr);
    }

    if (intval($current_user->plugin_info["silence_start"]) + intval($current_user->plugin_info["silence_time"]) > my_time()) {
        if ($banStr != "") $banStr .= "<br>";
        $banStr .= $w_roz_silenced_mess . date("d.m.Y H:i:s", intval(intval($current_user->plugin_info["silence_start"]) + intval($current_user->plugin_info["silence_time"])));
    }

    if (intval($current_user->plugin_info["chaos_start"]) + intval($current_user->plugin_info["chaos_time"]) > my_time()) {
        if ($banStr != "") $banStr .= "<br>";
        $banStr .= $w_roz_chaos_mess . date("d.m.Y H:i:s", intval(intval($current_user->plugin_info["chaos_start"]) + intval($current_user->plugin_info["chaos_time"])));
    }

    if (intval($current_user->plugin_info["jail_start"]) + intval($current_user->plugin_info["jail_time"]) > my_time()) {
        if ($banStr != "") $banStr .= "<br>";
        $banStr .= $w_roz_jailed_mess . date("d.m.Y H:i:s", intval(intval($current_user->plugin_info["jail_start"]) + intval($current_user->plugin_info["jail_time"])));
    }

    if ($banStr != "") {
        ?>
        <tr>
            <td>
                <table bgcolor="#fcc1c1" style="border: solid 1 #ff0000" width="90%" align="center" cellspacing="3"
                       cellpadding="3">
                    <tr>
                        <td width="50" align="center" valign="middle">
                            <img src="<?= $current_design ?>main/s_warn.png">
                        </td>
                        <td><font color="Red"><b><?= $banStr ?></b></font>
                        <td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <?php
    }
    ?>
    <?php if ($current_user->clan_id > 0) {
        $current_clan = new Clan();

        $is_regist_clan = $current_user->clan_id;
        include($ld_engine_path . "clan_get_object.php");
        ?>
        <tr>
            <td>
                <table bgcolor="#EAEAEA" style="border: solid 1 #666666" width="90%" align="center">
                    <tr>
                        <td>
                            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>
                                        <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td align="CENTER"><?= $w_roz_clan . ":" ?> <b><font
                                                                color="#bf0d0d"><?php echo $current_clan->name; ?></font></b>
                                                </td>
                                            </tr>
                                            <?php

                                            if (is_file($file_path . "clans-logos/" . floor($is_regist_clan / 2000) . "/" . $is_regist_clan . ".gif")) {
                                                $pic = $file_path . "clans-logos/" . floor($is_regist_clan / 2000) . "/" . $is_regist_clan . ".gif";
                                                $pic_url = $chat_url . "clans-logos/" . floor($is_regist_clan / 2000) . "/" . $is_regist_clan . ".gif";
                                            } else if (is_file($file_path . "clans-logos/" . floor($clan_id / 2000) . "/" . $is_regist_clan . ".jpg")) {
                                                $pic = $file_path . "clans-logos/" . floor($clan_id / 2000) . "/" . $is_regist_clan . ".jpg";
                                                $pic_url = $chat_url . "clans-logos/" . floor($is_regist_clan / 2000) . "/" . $is_regist_clan . ".jpg";
                                            }

                                            list($roz_width, $roz_height, $type, $attr) = getimagesize($pic);

                                            if ($roz_width > 200 or $roz_height > 200) {

                                                if ($roz_width > 200) {
                                                    $ratio = 200 / $roz_width;
                                                    $roz_width = 200;
                                                    $roz_height = $roz_height * $ratio;
                                                }
                                                if ($roz_height > 200) {
                                                    $ratio = 200 / $roz_height;
                                                    $roz_height = 200;
                                                    $roz_width = $roz_width * $ratio;
                                                }
                                            }

                                            ?>
                                            <tr>
                                                <td align=CENTER valign=middle><img src="<?php echo $pic_url; ?>"
                                                                                    width="<?= $roz_width ?>"
                                                                                    height="<?= $roz_height ?>"
                                                                                    border="<?php echo $current_clan->border; ?>">
                                                </td>
                                            </tr>
                                            <?php
                                            if ($current_user->clan_status == "0") $current_user->clan_status = "";
                                            if ($current_user->clan_status != "") {
                                                ?>
                                                <tr>
                                                    <td align="CENTER"><?= $w_roz_clan_status . ":" ?> <b><font
                                                                    color="#bf0d0d"><?php echo $current_user->clan_status; ?></font></b>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </table>
                                    </td>
                                    <td valign="middle" align="center">
                                        <?php echo $w_roz_clan_email ?>:<br>
                                        <nobr>
                                            <font color="#bf0d0d"><?= str_replace("@", " [at] ", $current_clan->email) ?></font>
                                        </nobr>
                                        <br>
                                        <?php echo $w_roz_clan_url ?>:<br>
                                        <nobr><?php echo "<a href=\"" . $chat_url . "go.php?url=" . urlencode($current_clan->url) . "\" target=\"_blank\">"; ?>
                                            <font color="#bf0d0d"><?= $current_clan->url ?></font></a></nobr>
                                        <br>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <?php
    }
    if ($act == "view_personal" and $IsModer) {
        ?>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>
                <table style="border: solid 1 #666666" width="90%" align="center">
                    <tr>
                        <td>
                            <?php
                            set_variable("moder_user_id");
                            $moder_user_id = intval($moder_user_id);

                            if (!$exists) {
                                $error_text = "$w_no_user";
                                include($file_path . "designes/" . $design . "/error_page.php");

                                exit;
                            }
                            $old_reg = $is_regist;
                            $is_regist = $moder_user_id;

                            if ($IsModer) {
                            echo "<table cellspacing=2 cellpadding=2>\n";
                            echo "<tr><td colspan=4><FONT color=#bf0d0d><b>$w_roz_personal_file</b></FONT></td></tr>\n";
                            echo "<tr><td colspan=4 align=CENTER>&nbsp;</td></tr>\n";

                            include($ld_engine_path . "moder_board_get_messages.php");
                            $MaxModerMsgs = count($moder_board_messages);

                            for ($i = 0; $i < $MaxModerMsgs; $i++) {
                                echo "<tr><td></td><td><font size=-1>" . $moder_board_messages[$i]["date"] . "</font></td><td></td><td><b>";
                                if (trim($moder_board_messages[$i]["from"]) != "") echo "<font color=Red>" . trim($moder_board_messages[$i]["from"]) . ": ";
                                echo $moder_board_messages[$i]["body"] . "</b>";
                                if (trim($moder_board_messages[$i]["from"]) != "") echo "</font>";
                                echo "</td></tr>\n";
                            }

                            ?>
                            <form method="post" action="profile_content.php">
                                <input type="hidden" name="session" value="<?php echo $session; ?>">
                                <input type="hidden" name="act" value="add_personal">
                                <input type="hidden" name="moder_user_id" value="<?php echo $is_regist; ?>">
                                <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                                <?php
                                echo "<tr><td colspan=2>\n";
                                ?>
                                <input type="text" size=25 name="moder_message" class="input">
                        </td>
                        <?php
                        echo "<td colspan=2>\n";
                        ?>
                        <input type="submit" value="<?php echo $w_roz_add_personal; ?>" class="input_button"></td></tr>
                    </form>
                    <?php
                    echo "</table>";
                    }

                    $is_regist = $old_reg;
                    ?>
                    </td>
                    </tr>
                </table>
            </td>
        </tr>
        <?php
        include($file_path . "designes/" . $design . "/common_body_end.php");
        exit();
    } ?>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>
            <table align=center border=0>
                <tr>
                    <td align="right"><?php echo $w_email; ?>:</font></td>
                    <td><font color="#bf0d0d"><?= str_replace("@", " [at] ", $current_user->email); ?></font></td>
                </tr>
                <tr>
                    <td align="right">ICQ:</td>
                    <td><font color="#bf0d0d">&nbsp;<?php echo $current_user->icquin; ?></font>
                        <?php if ($current_user->icquin != "") { ?>
                            <img src="http://status.icq.com/online.gif?icq=<?= preg_replace("/[^0-9]/", "", $current_user->icquin) ?>&img=5">
                        <?php } ?>
                    </td>
                </tr>
                <tr>
                    <td align="right"><?php echo $w_homepage; ?>:</td>
                    <td>
                        &nbsp;<?php echo "<a href=\"" . $chat_url . "go.php?url=" . urlencode($current_user->url) . "\" target=\"_blank\"><font color=\"#bf0d0d\">" . $current_user->url . "</font></a>"; ?></td>
                </tr>
                <?php
                $r_days = intval($current_user->online_time / (24 * 3600));
                $r_hours = intval(($current_user->online_time - $r_days * 24 * 3600) / 3600);
                $r_minutes = intval(($current_user->online_time - $r_days * 24 * 3600 - $r_hours * 3600) / 60);
                $r_seconds = intval($current_user->online_time - $r_days * 24 * 3600 - $r_hours * 3600 - $r_minutes * 60);

                $current_user->damneds = intval(trim($current_user->damneds));
                $current_user->rewards = intval(trim($current_user->rewards));
                ?>
                <?php if ($IsMyProfile or $IsModer) { ?>
                    <tr>
                        <td align="right"><?php echo $w_money; ?>:</td>
                        <td><font color="#bf0d0d"><b><?php echo $current_user->credits; ?></b></font></td>
                    </tr>
                <?php }
                if ($IsMember and $current_user->is_member) {
                    ?>
                    <tr>
                        <td align="right"><?php echo $w_membered_by; ?> :</td>
                        <td><font color="#bf0d0d"><b><?php echo $current_user->membered_by; ?></b></font></td>
                    </tr>
                <?php }
                ?>
                <tr>
                    <td align="right"><?php echo $w_roz_reiting; ?> :</td>
                    <td>
                        <font color="#bf0d0d"><b><?php echo "$r_days $w_days $r_hours:$r_minutes:$r_seconds / " . $current_user->online_time; ?></b></font>
                    </td>
                </tr>
                <tr>
                    <td align="right"><?php echo $w_roz_points; ?> :</td>
                    <td><font color="#bf0d0d"><b><?php echo $current_user->points; ?></b></font></td>
                </tr>
                <tr>
                    <td align=right><?php echo $w_roz_reward; ?>:</td>
                    <td><font color="#bf0d0d"><?php echo $current_user->rewards; ?></font></td>
                </tr>
                <tr>
                    <td align=right><?php echo $w_roz_damneds; ?>:</td>
                    <td><font color="#bf0d0d"><?php echo $current_user->damneds; ?></font></td>
                </tr>
                <tr>
                    <td align=right><?php echo $w_roz_last_action_tim; ?>:</td>
                    <td>
                        <font color="#bf0d0d">&nbsp;<?php echo date("d.m.Y H:i:s", intval(intval($current_user->last_actiontime) + $time_offset * 3600)); ?></font>
                    </td>
                </tr>
                <tr>
                    <td align=right><?php echo $w_roz_family; ?>:</td>
                    <td><font color="#bf0d0d"><b>&nbsp;<?php
                                if ($current_user->married_with != "") {

                                    if ($current_user->sex == 1) {
                                        echo $w_roz_marr_man_yes;
                                    } else if ($current_user->sex == 2) {
                                        echo $w_roz_marr_wom_yes;
                                    } else {
                                        echo $w_roz_marr_it_yes;
                                    }

                                    $user_to_search = $current_user->married_with;
                                    $u_ids = array();
                                    include($ld_engine_path . "users_search.php");
                                    echo " ";
                                    if (count($u_ids)) {
                                        for ($i = 0; $i < count($u_ids); $i++) {
                                            if (strcasecmp($u_names[$i], $user_to_search) == 0) {
                                                echo "<a target=_parent href='" . $chat_url . "fullinfo.php?session=$session&user_id=" . $u_ids[$i] . "'>";
                                                break;
                                            }
                                        }

                                    }
                                    echo "<b>" . $current_user->married_with . "</b>";
                                    if (count($u_ids)) {
                                        echo "</a>";
                                    }

                                } else {
                                    if ($current_user->sex == 1) {
                                        echo $w_roz_marr_man_no;
                                    } else if ($current_user->sex == 2) {
                                        echo $w_roz_marr_wom_no;
                                    } else {
                                        echo $w_roz_marr_it_no;
                                    }
                                }
                                ?></b></font></td>
                </tr>

            </table>
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td><?php
            if (file_exists($file_path . 'inc_banner.php')) require($file_path . 'inc_banner.php');
            ?></td>
    </tr>
    <tr>
        <td><font color="#bf0d0d" size=+1><b><?= $w_addit_info ?>:</b></font></td>
    </tr>
    <tr>
        <td>
            <blockquote><?= $current_user->about ?></blockquote>
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <?php

    if ($IsModer) {
        if (is_file($file_path . "designes/" . $design . "/browser/phpSniff.class.php")) {
            $IsSniff = true;
            include($file_path . "designes/" . $design . "/browser/phpSniff.class.php");

            $sniffer_settings = array('check_cookies' => false,
                'default_language' => "",
                'allow_masquerading' => false);

            $sniff = new phpSniff($current_user->user_agent, $sniffer_settings);
        } else $IsSniff = false;
        ?>
        <tr>
            <td>
                <table bgcolor="#EAEAEA" style="border: solid 1 #666666" width="90%" align="center">
                    <tr>
                        <td>
                            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td colspan="2"><b><?= $w_classified_info ?>:</b></td>
                                </tr>
                                <tr>
                                    <td colspan="2">&nbsp;</td>
                                </tr>
                                <?php if ($IsSniff) { ?>
                                    <tr>
                                        <td><?= $w_info_browser ?>:</td>
                                        <td><?php
                                            $br_name = "";

                                            $br_type = $sniff->property('browser');

                                            foreach ($sniff->_browsers as $key => $value) {
                                                if (!strcasecmp($value, $br_type)) {
                                                    $br_name = ucwords($key);
                                                    break;
                                                }
                                            }

                                            if ($br_name == "") $br_name = $sniff->property('long_name');

                                            echo $br_name . " " . $sniff->property('version');

                                            ?></td>
                                    </tr>
                                    <tr>
                                        <td><?= $w_info_os ?>:</td>
                                        <td><?= ucwords($sniff->property('platform')) . " " . ucwords($sniff->property('os')); ?></td>
                                    </tr>
                                <?php } ?>
                                <tr>
                                    <td>IP:</td>
                                    <td><b><font color="#bf0d0d"><?= $current_user->IP ?></font> / (WHOIS)</b></td>
                                </tr>
                                <tr>
                                    <td><?= $w_info_user_agent ?>:</td>
                                    <td><?= $current_user->user_agent ?></td>
                                </tr>
                                <tr>
                                    <td>ID:</td>
                                    <td><b><?php echo $is_regist; ?></b></td>
                                </tr>
                                <tr>
                                    <td><?php echo $w_roz_browser_id; ?>:</td>
                                    <td><?php echo $current_user->browser_hash; ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo $w_roz_registered_at; ?>:</td>
                                    <td>
                                        &nbsp;<?php echo date("d.m.Y H:i:s", intval($current_user->registered_at)); ?></td>
                                </tr>
                                <?php if ($IsAdmin) { ?>
                                    <tr>
                                        <td>Cookie:</td>
                                        <td><?php echo $current_user->cookie_hash; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Session:</td>
                                        <td><?php echo $current_user->session; ?></td>
                                    </tr>
                                <?php }
                                if ($current_user->reffered_by > 0) { ?>
                                    <tr>
                                        <td><?php echo $w_reffered_by; ?>:</td>
                                        <td><?php
                                            echo "<b><a target=_parent href='" . $chat_url . "fullinfo.php?session=$session&user_id=" . $current_user->reffered_by . "'>" . $current_user->reffered_by_nick . "</a></b>";
                                            ?></td>
                                    </tr>
                                <?php } ?>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    <?php } ?>
    <tr>
        <td>&nbsp;</td>
    </tr>

    <tr>
        <td>&nbsp;</td>
    </tr>
    <?php
    if ($IsModer) {
        ?>
        <tr>
            <td>
                <table style="border: solid 1 #666666" width="90%" align="center">
                    <tr>
                        <td>
                            <?php
                            echo "<table cellspacing=2 cellpadding=2 align=CENTER bgcolor=#FFFFFF>\n";
                            echo "<tr><td colspan=4><FONT color=#bf0d0d><b>$w_roz_personal_file</b></FONT></td></tr>\n";
                            echo "<tr><td colspan=4>&nbsp;</td></tr>\n";
                            include($ld_engine_path . "moder_board_get_messages.php");
                            $MaxModerMsgs = count($moder_board_messages);

                            $ModerViewed = 0;

                            for ($i = 0; $i < $MaxModerMsgs; $i++) {

                                if ($ModerViewed > (MODER_LOG_LIMIT - 1)) break;

                                echo "<tr><td></td><td><font size=-1>" . $moder_board_messages[$i]["date"] . "</font></td><td></td><td><b>";
                                if (trim($moder_board_messages[$i]["from"]) != "") echo "<font color=Red>" . $moder_board_messages[$i]["from"] . ": ";
                                echo $moder_board_messages[$i]["body"] . "</b>";
                                if (trim($moder_board_messages[$i]["from"]) != "") echo "</font>";
                                echo "</td></tr>\n";
                                $ModerViewed++;
                            }

                            if (count($moder_board_messages) > MODER_LOG_LIMIT) {
                                echo "<tr><td colspan=4 align=right><a href='" . $current_design . "profile_content.php?session=$session&moder_user_id=$is_regist&user_id=$user_id&act=view_personal'><b>$w_roz_more_personal</b></a></td></tr>\n";
                            }

                            ?>
                            <form method="post" action="profile_content.php">
                                <input type="hidden" name="session" value="<?php echo $session; ?>">
                                <input type="hidden" name="act" value="add_personal">
                                <input type="hidden" name="moder_user_id" value="<?php echo $is_regist; ?>">
                                <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                                <?php
                                echo "<tr><td colspan=4 align=CENTER>\n";
                                ?>
                                <input type="text" size=25 name="moder_message" class="input">
                                <input type="submit" value="<?php echo $w_roz_add_personal; ?>" class="input_button">
                        </td>
                    </tr>
                    </form>
                    <?php
                    echo "</table>";
                    ?>
                    </td></tr></table>
            </td>
        </tr>
        <?php
    }
    ?>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <?php

    if (count($current_user->items) > 0) {
        ?>
        <tr>
            <td>
                <table style="border: solid 1 #666666" width="90%" align="center">
                    <tr>
                        <td>
                            <?php
                            include($ld_engine_path . "class_items.php");
                            include($ld_engine_path . "get_item_list.php");
                            $items_to_render = array();

                            $actions = array();
                            $items = $current_user->items;
                            @reset($items);
                            echo "<table cellspacing=2 cellpadding=2 align=CENTER bgcolor=#FFFFFF>\n";
                            echo "<tr><td align=left><FONT color=#bf0d0d><b>$w_roz_personal_items</b></FONT></td></tr>\n";
                            ?>
                    <tr>
                        <td>
                            <table cellspacing=3 cellpadding=3 border=0 align="center">
                                <?php

                                $a = 0;

                                while (list($i, $curr_item) = @each($items)) {
                                    if (intval($curr_item['ItemID']) == 0) continue;
                                    if ($a == 0) echo "<tr>\n";
                                    echo "<td><img help=\"<small><font color=black><b>" . htmlspecialchars($item_list[$curr_item['ItemID']]->title) . "</b><br><center> " . wordwrap($curr_item["Reason"], 20, "<br>") . "<br>(" . date("d-m-Y", intval($curr_item["Date"])) . ", <i>" . $curr_item["FromNick"] . "</i>)</center></font></small>\" src=\"" . $chat_url . "items/" . $item_list[$curr_item['ItemID']]->image . "\" border=0></td>\n";
                                    if ($a == 4 or $a == count($items) - 1) {
                                        echo "</tr>\n";
                                        $a = 0;
                                    } else $a++;
                                }
                                ?>
                            </table>
                        </td>
                    </tr>
                    <?php
                    echo "</table>";
                    ?>
                    </td></tr></table>
            </td>
        </tr>
        <?php
    }

    ?>
    </td></tr>
</table>

</body>
</html>