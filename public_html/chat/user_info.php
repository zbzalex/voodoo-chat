<?php

require_once __DIR__ . "/../../vendor/autoload.php";
require_once __DIR__ . "/inc_common.php";

include($engine_path . "users_get_list.php");

include($file_path . "tarrifs.php");

if (!$exists) {
    $error_text = "$w_no_user";
    include($file_path . "designes/" . $design . "/error_page.php");
    exit;
}

if (!$is_regist_complete) {
    header("Location: " . $chat_url . "registration_form.php?session=$session&user_name=" . urlencode($user_name));
    exit;
}

include("inc_user_class.php");
include_once($data_path . "engine/files/user_log.php");
include($ld_engine_path . "users_get_object.php");

include($engine_path . "class_items.php");
include($engine_path . "get_item_list.php");

// password lifetime check.
// first introduced in VOC++ BSE
if ($current_user->user_class > 0 or
    $current_user->custom_class > 0 or
    $current_user->allow_pass_check) {

    $CanBeDone = true;
    if ($current_user->last_pass_check < my_time() - PASS_CHANGE_TIME) $CanBeDone = false;

    set_variable("act");
    if ($act == "change_pass") {

        set_variable("old_password");
        set_variable("passwd1");
        set_variable("passwd2");

        $info_message = "";
        $passwd1 = str_replace("\t", "", $passwd1);
        if ((!$passwd1) or ($passwd1 != $passwd2))
            $info_message = $w_password_mismatch;
        else {
            if ($md5_salt == "") {
                if ($current_user->password == md5($old_password)) {

                    if ($current_user->password != md5($passwd1)) {
                        $current_user->password = md5($passwd1);
                        $current_user->last_pass_check = my_time();

                        $User_UpdatePassword = true;
                        include($ld_engine_path . "user_info_update.php");
                        $CanBeDone = true;
                    } else {
                        $info_message = $w_incorrect_password . "!";
                    }
                } else {
                    $info_message = $w_incorrect_password . "!";
                }
            } else {
                $passSalt = md5($old_password);
                $passSalt = $md5_salt . $passSalt;
                $passSalt = md5($passSalt);

                if ($current_user->password == $passSalt or $current_user->password == md5($old_password)) {
                    $passSalt = md5($passwd1);
                    $passSalt = $md5_salt . $passSalt;
                    $passSalt = md5($passSalt);

                    if ($current_user->password != $passSalt) {
                        $current_user->password = $passSalt;

                        $User_UpdatePassword = true;
                        $current_user->last_pass_check = my_time();
                        include($ld_engine_path . "user_info_update.php");
                        $CanBeDone = true;
                    } else {
                        $info_message = $w_incorrect_password . "!";
                    }
                } else {
                    $info_message = $w_incorrect_password . "!";
                }
            }

        }

    }

    if (!$CanBeDone) {
        include($file_path . "designes/" . $design . "/pass.php");
        exit;
    }
}


set_variable("op");

if ($op == "do_exchange" and $is_regist_complete) {


    if (intval($current_user->plugin_info["chaos_start"]) + intval($current_user->plugin_info["chaos_time"]) > my_time()) {
        $MsgToPass = $w_user_chaos;
        $MsgToPass = str_replace("~", date("d.m.Y H:i:s", intval($current_user->plugin_info["chaos_start"]) + intval($current_user->plugin_info["chaos_time"])), $MsgToPass);
        $error_text = $MsgToPass;
        include($file_path . "designes/" . $design . "/error_page.php");
        exit;
    }


    set_variable("crd");
    $crd = intval($crd);
    if ($crd < 0) $crd = 0;

    if ($crd > $current_user->points) {
        $error_text = $w_no_credits;
        $op = "exchange";
    } else if ($crd < $tarrifs["tax"]) {
        $error_text = $w_no_credits;
        $op = "exchange";
    } else {
        $oldCrd = $current_user->credits;
        $current_user->credits += intval($crd / $tarrifs["tax"]);
        $current_user->points -= intval($crd / $tarrifs["tax"]) * $tarrifs["tax"];
        include($ld_engine_path . "user_info_update.php");

        include_once($data_path . "engine/files/user_log.php");

        $fp = fopen($data_path . "users/exchanges.log", "a+b");
        if ($fp) {
            fwrite($fp, date("H:i:s d-m-Y", my_time()) . "\t" . $user_name . "\t" . $current_user->nickname . "\t" . $crd . "\t" . $current_user->points . "\n");
            fclose($fp);
        }

        $MsgToPass = $sw_adm_user_exchange;
        $MsgToPass = str_replace("~", intval($crd / $tarrifs["tax"]) * $tarrifs["tax"], $MsgToPass);
        $MsgToPass = str_replace("#", intval($crd / $tarrifs["tax"]), $MsgToPass);
        $MsgToPass = str_replace("$", $oldCrd, $MsgToPass);
        $MsgToPass = str_replace("%", $current_user->credits, $MsgToPass);

        if ($current_user->reffered_by > 0 and
            $current_user->ref_payment_done) {

            $old_reg = $is_regist;
            $old_user = $current_user;

            $is_regist = $current_user->reffered_by;
            include($ld_engine_path . "users_get_object.php");

            $toAdd = intval(intval($crd / $tarrifs["tax"]) * 0.1);
            if ($toAdd <= 0) $toAdd = 1;

            $oldCrd = $current_user->credits;
            $current_user->credits += $toAdd;
            include($ld_engine_path . "user_info_update.php");

            $MsgToPass = $w_adm_reffered_payment;
            $MsgToPass = str_replace("#", $toAdd, $MsgToPass);
            $MsgToPass = str_replace("~", $old_user->nickname . " (EX)", $MsgToPass);
            $MsgToPass = str_replace("$", $oldCrd, $MsgToPass);
            $MsgToPass = str_replace("%", $current_user->credits, $MsgToPass);

            $is_regist = $old_reg;
            $current_user = $old_user;
        }

        $op = "";
    }
}

if ($op == "do_transfer" and $is_regist_complete) {

    if (intval($current_user->plugin_info["chaos_start"]) + intval($current_user->plugin_info["chaos_time"]) > my_time()) {
        $MsgToPass = $w_user_chaos;
        $MsgToPass = str_replace("~", date("d.m.Y H:i:s", intval($current_user->plugin_info["chaos_start"]) + intval($current_user->plugin_info["chaos_time"])), $MsgToPass);
        $error_text = $MsgToPass;
        include($file_path . "designes/" . $design . "/error_page.php");
        exit;
    }

    set_variable("crd_transfer");
    $crd_transfer = intval($crd_transfer);
    if ($crd_transfer < 0) $crd_transfer = 0;

    if ($crd_transfer == 0) {
        $error_text = $w_no_money;
        $op = "transfer";
    }

    set_variable("pass_transfer");

    if ($md5_salt == "") {
        if ($current_user->password != md5($pass_transfer)) {
            $error_text = $w_incorrect_password;
            $op = "transfer";
        }
    } else {
        $passSalt = md5($pass_transfer);
        $passSalt = $md5_salt . $passSalt;
        $passSalt = md5($passSalt);

        if ($current_user->password != $passSalt and $current_user->password != md5($pass_transfer)) {
            $error_text = $w_incorrect_password;
            $op = "transfer";
        }
    }

    if (intval($crd_transfer + $tarrifs["transfer"]) < 0) {
        $error_text = $w_no_money;
        $op = "transfer";
    }
    if (intval($crd_transfer + $tarrifs["transfer"]) > $current_user->credits) {
        $error_text = $w_no_money;
        $op = "transfer";
    }

    if ($error_text == "") {
        set_variable("user_transfer");
        $user_transfer = preg_replace("/[^$nick_available_chars]/", "", $user_transfer);

        set_variable("clan_transfer");
        $clan_transfer = intval($clan_transfer);

        if ($user_transfer != "") {
            //user-to-user transfer
            $user_to_search = $user_transfer;

            $u_ids = array();
            include($ld_engine_path . "users_search.php");

            $IsFound = 0;

            if (count($u_ids)) {
                for ($j = 0; $j < count($u_ids); $j++) {
                    if (strcasecmp(trim($u_names[$j]), $user_to_search) == 0) {
                        $send_to_id = $u_ids[$j];
                        $IsFound = 1;
                        break;
                    }
                }
            }
            if (!$IsFound) {
                $error_text = $w_no_user;
                $op = "transfer";
            } else if ($send_to_id != $is_regist) {
                $oldOne = $is_regist;
                $oldNick = $current_user->nickname;
                $oldCrd = $current_user->credits;

                $total_money = intval($crd_transfer + $tarrifs["transfer"]);
                if ($total_money <= 0 or $total_money > $oldCrd) $total_money = 1;
                $current_user->credits -= intval($total_money);
                include($ld_engine_path . "user_info_update.php");

                $fp = fopen($data_path . "users/money_transfer.log", "a+b");
                if ($fp) {
                    fwrite($fp, date("H:i:s d-m-Y", my_time()) . "\t" . $user_name . "\t" . $user_to_search . "\t" . $total_money . "\t" . $current_user->credits . "\n");
                    fclose($fp);
                }

                $oldNCrd = $current_user->credits;

                //target user
                $is_regist = $send_to_id;
                include($ld_engine_path . "users_get_object.php");
                $nCrd = $current_user->credits;

                $fp = fopen($data_path . "users/money_transfer.log", "a+b");
                if ($fp) {
                    fwrite($fp, date("H:i:s d-m-Y", my_time()) . "\t" . $user_name . "\t" . $user_to_search . "\t" . $crd_transfer . "\t" . $current_user->credits . "\n");
                    fclose($fp);
                }

                $current_user->credits += intval($crd_transfer);
                include($ld_engine_path . "user_info_update.php");

                //����� ������� � ���
                $MsgToPass = $sw_adm_money_transfer_from;
                $MsgToPass = str_replace("#", $crd_transfer, $MsgToPass);
                $MsgToPass = str_replace("~", $current_user->nickname . " (id: $is_regist)", $MsgToPass);
                $MsgToPass = str_replace("$", $oldCrd, $MsgToPass);
                $MsgToPass = str_replace("%", $oldNCrd, $MsgToPass);

                //����� ������� � ���
                $MsgToPass = $sw_adm_money_transfer;
                $MsgToPass = str_replace("#", $crd_transfer, $MsgToPass);
                $MsgToPass = str_replace("~", $oldNick . " (id: $oldOne)", $MsgToPass);
                $MsgToPass = str_replace("$", $nCrd, $MsgToPass);
                $MsgToPass = str_replace("%", $current_user->credits, $MsgToPass);

                $is_regist = $oldOne;
                include($ld_engine_path . "users_get_object.php");
                $op = "";
            }

        } else if ($clan_transfer == 1 and $current_user->clan_id > 0) {
            //user-to-clan transfer
            $oldCrd = $current_user->credits;

            $total_money = $crd_transfer + $tarrifs["transfer"];
            $current_user->credits -= intval($total_money);
            include($ld_engine_path . "user_info_update.php");

            $current_clan = new Clan;

            $is_regist_clan = intval($current_user->clan_id);
            include($ld_engine_path . "clan_get_object.php");

            $oldClanCrd = $current_clan->credits;
            $current_clan->credits += $crd_transfer;

            //����� ������� � ���
            $MsgToPass = $sw_adm_money_transfer_from;
            $MsgToPass = str_replace("#", $crd_transfer, $MsgToPass);
            $MsgToPass = str_replace("~", $w_clan_treasury . " \"" . $current_clan->name . "\"", $MsgToPass);
            $MsgToPass = str_replace("$", $oldCrd, $MsgToPass);
            $MsgToPass = str_replace("%", $current_user->credits, $MsgToPass);
            //����� ����� � ���
            $MsgToPass = $sw_adm_money_transfer;
            $MsgToPass = str_replace("#", $crd_transfer, $MsgToPass);
            $MsgToPass = str_replace("~", $current_user->nickname, $MsgToPass);
            $MsgToPass = str_replace("$", $oldClanCrd, $MsgToPass);
            $MsgToPass = str_replace("%", $current_clan->credits, $MsgToPass);

            $current_clan->money_log[] = array("time" => my_time(),
                "body" => $MsgToPass);

            include($ld_engine_path . "clan_update_object.php");

            $op = "";
        }
    } else $op = "transfer";
}


//Added by MisterX
$actions = array();
$items = $current_user->items;
@reset($items);
while (list($id, $item) = @each($items)) {
    $items_to_render[$id] = $item_list[$item['ItemID']];
    if ($item['Present'] == 1 or $item['Present'] == '1')
        $items_presents[$id] = 1;
    else
        $items_presents[$id] = 0;

    if ($item_list[$item['ItemID']]->action != "0" && !empty($item_list[$item['ItemID']]->action)) {
        if (file_exists($engine_path . "item_actions/" . $item_list[$item['ItemID']]->action . "/frontend.php"))
            $actions[] = $item_list[$item['ItemID']]->action;
    }
}

$pic_name = "" . floor($is_regist / 2000) . "/" . $is_regist . ".big.gif";
if (!file_exists($file_path . "photos/$pic_name")) $pic_name = "";
if ($pic_name == "") {
    $pic_name = "" . floor($is_regist / 2000) . "/" . $is_regist . ".big.jpg";
    if (!file_exists($file_path . "photos/$pic_name")) $pic_name = "";
}
if ($pic_name == "") {
    $pic_name = "" . floor($is_regist / 2000) . "/" . $is_regist . ".big.jpeg";
    if (!file_exists($file_path . "photos/$pic_name")) $pic_name = "";
}
$big_picture = $pic_name;

$pic_name = "" . floor($is_regist / 2000) . "/" . $is_regist . ".gif";
if (!file_exists($file_path . "photos/$pic_name")) $pic_name = "";
if ($pic_name == "") {
    $pic_name = "" . floor($is_regist / 2000) . "/" . $is_regist . ".jpg";
    if (!file_exists($file_path . "photos/$pic_name")) $pic_name = "";
}
$small_picture = $pic_name;
$w_big_photo = str_replace("~", $max_photo_size, str_replace("*", $max_photo_width, str_replace("#", $max_photo_height, $w_big_photo)));

?>
<!doctype html>
<html>
<head></head>
<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" rightmargin="0" bottommargin="0" marginwidth="0"
      marginheight="0">
<SCRIPT src="<?= $current_design; ?>tabsheets.js"></SCRIPT>
<LINK rel="stylesheet" type="text/css" href="<?= $current_design; ?>tabsheets.css"/><?php

if ($op == "exchange") {
    echo "<b>$w_money_exchange:</b><br>";
    ?>
    <FORM method="post" action="user_info.php" enctype="multipart/form-data">
        <INPUT type="hidden" name="MAX_FILE_SIZE" value="300000">
        <INPUT type="hidden" name="session" value="<?php echo $session; ?>">
        <INPUT type="hidden" name="op" value="do_exchange">
        <TABLE border="0" cellpadding="0" cellspacing="0">
            <TR>
                <TD><B><FONT color="red"><?= $error_text ?></FONT></B>
                </TD>
            </TR>
            <TR>
                <TD><?= $w_roz_reiting ?>:
                </TD>
                <TD><B><?= $current_user->points ?></B>
                </TD>
            </TR>
            <TR>
                <TD><?= $w_money ?>:
                </TD>
                <TD><B><?= $current_user->credits ?></B>
                </TD>
            </TR>
            <TR>
                <TD><?= $w_exchange_tax ?>:
                </TD>
                <TD><B>1 :<?= $tarrifs["tax"] ?></B>
                </TD>
            </TR>
            <TR>
                <TD><?= $w_howmany_exchange ?>:
                </TD>
                <TD><B>
                        <INPUT type="text" name="crd" value="<?= intval($crd) ?>" class="input"></B>
                </TD>
            </TR>
        </TABLE>
        <INPUT type="submit" value="<?= $w_exchange_do ?>" class="input_button">
    </FORM>
    <?php

    exit;
}

if ($op == "transfer") {
    echo "<b>$w_money_transfer</b><br>";
    ?>
    <FORM method="post" action="user_info.php">
    <INPUT type="hidden" name="session" value="<?php echo $session; ?>">
    <INPUT type="hidden" name="op" value="do_transfer">
    <TABLE border="0" cellpadding="2" cellspacing="2" width="500">
        <TR>
            <TD><B><FONT color="red"><?= $error_text ?></FONT></B>
            </TD>
        </TR>
        <TR>
            <TD><?= $w_money ?>:
            </TD>
            <TD><B><?= $current_user->credits ?></B>
            </TD>
        </TR>
        <TR>
            <TD colspan="2"><SMALL><?= str_replace("#", $tarrifs["transfer"], $w_money_transfer_note) ?></SMALL>
            </TD>
        </TR>
        <TR>
            <TD><?= $w_money_transfer_amount ?>:
            </TD>
            <TD><B>
                    <INPUT type="text" name="crd_transfer" value="<?= intval($crd_transfer) ?>" class="input"></B>
            </TD>
        </TR>
        <TR>
            <TD colspan="2"><SMALL><?= $w_money_transfer_destination ?></SMALL>
            </TD>
        </TR>
        <TR>
            <TD><?= $w_roz_user ?>:
            </TD>
            <TD>
                <INPUT type="text" name="user_transfer" value="<?= $user_transfer ?>" class="input">
            </TD>
        </TR><?php if ($current_user->clan_id > 0) { ?>
            <TR>
            <TD colspan="2">
                <INPUT type="checkbox" name="clan_transfer" value="1">&nbsp;<?= $w_usr_clan ?>
            </TD>
            </TR><?php } ?>
        <TR>
            <TD colspan="2"><SMALL><?= $w_money_transfer_password ?></SMALL>
            </TD>
        </TR>
        <TR>
            <TD><?= $w_password ?>:
            </TD>
            <TD><B>
                    <INPUT type="password" name="pass_transfer" class="input"></B>
            </TD>
        </TR>
    </TABLE>
    <INPUT type="submit" value="<?= $w_money_transfer_accept ?>" class="input_button">
    </FORM>
    <?php

    exit;
}
?>
<?php if (sizeof($actions) > 0) { ?>
    <DT><?= $w_add_features ?></DT>
    <DD>
    <DIV class="reducer">
        <TABLE>
            <TR>
                <TD><STRONG><?= $w_shop_actions ?>:</STRONG>
                </TD>
            </TR><?php
            @reset($actions);
            while (list($id, $action) = @each($actions)) {
                ?>
                <TR>
                <TD nowrap><?php
                    include $engine_path . "item_actions/" . $action . "/frontend.php";
                    ?>
                </TD>
                </TR><?php } ?>
        </TABLE>
    </div>
    </dd><?php } ?>
<SCRIPT>function shop_submit(itemID, what) {
        document.shop.itemID.value = itemID;
        document.shop.what.value = what;
        document.shop.submit();
    }
</SCRIPT>

<FORM name="shop" action="shop_actions.php" method="post">
    <INPUT type="Hidden" name="itemID">
    <INPUT type="Hidden" name="session" value="<?= $session ?>">
    <INPUT type="Hidden" name="what" value="">
</FORM>

<FORM method="post" action="user_info_update.php" enctype="multipart/form-data">
    <INPUT type="hidden" name="MAX_FILE_SIZE" value="300000">
    <INPUT type="hidden" name="session" value="<?php echo $session; ?>">
    <DIV style="background: ButtonFace; padding: 1em;">
        <DL class="tabsheets">

            <DT><?= $w_about_user ?></DT>
            <DD>
                <DIV class="reducer">
                    <table cellspacing="2" cellpadding="2" border="0">
                        <tr>
                            <td rowspan="9"><?php
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
                                if ($pic_name == "") $pic_name = "no_photo.gif";
                                list($roz_width, $roz_height, $type, $attr) = getimagesize($file_path . "photos/" . $pic_name);
                                $CanBeEnlarged = false;

                                if ($roz_width > 300 or $roz_height > 300) {
                                    $CanBeEnlarged = true;

                                    if ($roz_width > 300) {
                                        $ratio = 300 / $roz_width;
                                        $roz_width = 300;
                                        $roz_height = $roz_height * $ratio;
                                    }
                                    if ($roz_height > 300) {
                                        $ratio = 300 / $roz_height;
                                        $roz_height = 300;
                                        $roz_width = $roz_width * $ratio;
                                    }
                                }

                                echo "<img src=\"" . $images_url . "photos/$pic_name\" width=\"$roz_width\" height=\"$roz_height\"><br>";
                                echo "<input type=\"checkbox\" name=\"big_del\">$w_check_for_delete<br>";
                                echo "$w_other_photo <input type=\"file\" name=\"big_photo\" class=\"input\">";
                                echo "<br><input type=\"checkbox\" name=\"allow_photo_reiting\" value=\"1\" ";
                                if ($current_user->photo_take_part) echo 'checked';
                                echo " >$w_photo_reiting_take_part<br>";

                                ?></td>
                            <td nowrap><?php echo $w_surname; ?>:</td>
                            <td nowrap><INPUT type="text" size="15" name="surname"
                                              value="<?php echo $current_user->surname; ?>" class="input"></td>
                        </tr>
                        <tr>
                            <td nowrap><?php echo $w_name; ?>:</td>
                            <td nowrap><INPUT type="text" size="15" name="firstname"
                                              value="<?php echo $current_user->firstname; ?>" class="input"></td>
                        </tr>
                        <tr>
                            <td nowrap><?php echo $w_birthday; ?>:</td>
                            <td nowrap><SELECT name="day" class="input">
                                    <OPTION value="">--</OPTION><?php
                                    for ($i = 1; $i < 32; $i++) {
                                        echo "<option";
                                        if ($i == $current_user->b_day) echo " selected";
                                        echo ">$i\n";
                                    } ?>
                                </SELECT> /
                                <SELECT name="month" class="input">
                                    <OPTION value="">--</OPTION><?php
                                    for ($i = 1; $i < 13; $i++) {
                                        echo "<option";
                                        if ($i == $current_user->b_month) echo " selected";
                                        echo ">$i\n";
                                    } ?>
                                </SELECT> /
                                <SELECT name="year" class="input">
                                    <OPTION value="">--</OPTION><?php
                                    for ($i = 1950; $i < 2001; $i++) {
                                        echo "<option";
                                        if ($i == $current_user->b_year) echo " selected";
                                        echo ">$i\n";
                                    } ?>
                                </SELECT></td>
                        </tr>
                        <tr>
                            <td nowrap><?php echo $w_city; ?>:</td>
                            <td nowrap><INPUT type="text" name="city" size="15"
                                              value="<?php echo $current_user->city; ?>" class="input"></td>
                        </tr>
                        <?php

                        echo "<tr><td nowrap>$w_gender: </td><td nowrap><select name=\"sex\" class=\"input\">";
                        $sex = $current_user->sex;
                        echo "<option value=0";
                        if ($sex == 0) echo " selected";
                        echo ">$w_unknown</option>\n<option value=1";
                        if ($sex == 1) echo " selected";
                        echo ">$w_male</option>\n<option value=2";
                        if ($sex == 2) echo " selected";
                        echo ">$w_female</option>\n</select></td></tr>\n"; ?>
                        <TR>
                            <TD><?php echo $w_email; ?>:
                            </TD>
                            <TD>
                                <INPUT type="text" size="15" name="email"
                                       value="<?php echo $current_user->email; ?>" class="input">
                            </TD>
                        </TR>
                        <TR>
                            <TD><?php echo $w_homepage; ?>:
                            </TD>
                            <TD>
                                <INPUT type="text" size="15" name="url" value="<?php echo $current_user->url; ?>"
                                       class="input">
                            </TD>
                        </TR>

                        <tr>
                            <td height="100%">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="3" align="left"><?php echo $w_addit_info ?>:</td>
                        </tr>
                        <tr>
                            <td colspan="3" align="center"><TEXTAREA name="comments" rows="10" cols="80"
                                                                     class="input"><?php echo str_replace("<br>", "\n", $current_user->about); ?></TEXTAREA>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="3" align="right">
                                <hr noshade>
                                <INPUT type="submit" value="<?php echo $w_update; ?>" class="input"></td>
                        </tr>
                    </table>

                </div>
            </dd>
            <DT><?= $w_security_opt ?></DT>
            <DD>
                <DIV class="reducer">
                    <table>
                        <TR>
                            <td>
                                <?php echo $w_limit_by_hash; ?>
                            </td>
                            <TD>
                                <INPUT type=checkbox value=1
                                       name="check_browser" <?php if ($current_user->check_browser == 1) echo " checked"; ?>>
                            </TD>
                        </TR>
                        <TR>
                            <td><?php echo $w_limit_by_cookie; ?></td>
                            <TD>
                                <INPUT type=checkbox value=1
                                       name="check_cookie" <?php if ($current_user->check_cookie == 1) echo " checked"; ?>>
                            </TD>
                        </TR>
                        <TR>
                            <td colspan="2"><?php echo $w_limit_by_ip_only ?>:</td>
                        </tr>
                        <tr>
                            <TD colspan="2" align="center"><INPUT size="80" type=text class="input" name="limit_ips"
                                                                  value="<?php echo $current_user->limit_ips; ?>">
                            </TD>
                        </TR>
                        <tr>
                            <td colspan="2" align="right">
                                <hr noshade>
                                <INPUT type="submit" value="<?php echo $w_update; ?>" class="input"></td>
                        </tr>
                    </table>
                </div>
            </dd>
            <DT><?= $w_items_opt ?></DT>
            <DD>
                <DIV class="reducer">
                    <div class="preframe" style="height: 500px;" align="center">
                        <table>
                            <?php if (count($items_to_render) > 0) { ?>
                                <TR>
                                <TD colspan="2">
                                    <TABLE border="0" cellpadding="0">
                                        <TR>
                                            <TD align="center" valign="bottom"><?php
                                                @reset($items_to_render);
                                                $c = 0;
                                                while (list($id, $item) = @each($items_to_render)) {
                                                    $c++;
                                                    ?>
                                                    <TABLE border="0" align="center">
                                                    <TR>
                                                        <TD colspan="2" align="center">
                                                            <STRONG><?= $item->title ?></STRONG></TD>
                                                    </TR>
                                                    <TR>
                                                        <TD colspan="2"
                                                            align="center"><?php if ($items_presents[$id] != 1) {
                                                                ?><A href="#"
                                                                     onClick="shop_submit(<?= $id ?>,'refund'); return false;"
                                                                     style="{ font-size: 8pt;}"><?= $w_shop_back ?></A><?php
                                                            } ?>&nbsp; <?php if ($items_presents[$id] != 1) {
                                                                ?><A href="#"
                                                                     onClick="shop_submit(<?= $id ?>,'give'); return false;"
                                                                     style="{ font-size: 8pt;}"><?= $w_shop_present ?></A><?php
                                                            } ?>&nbsp;
                                                        </TD>
                                                    </TR>
                                                    <TR>
                                                        <TD colspan="2" align="center"><IMG
                                                                    src="<?= $chat_url . "items/" . $item->image; ?>">
                                                        </TD>
                                                    </TR>
                                                    <TR>
                                                        <TD colspan="2"
                                                            align="center"><?php if ($items_presents[$id] != 1 and $current_user->credits >= $tarrifs["transaction"]) {
                                                                ?><A style="{ font-size: 8pt;}" href="#"
                                                                     onClick="shop_submit(<?= $id ?>,'transfer'); return false;"><?= $w_shop_transfer ?></A>
                                                                <?php
                                                            } ?>&nbsp;<A href="#"
                                                                         onClick="shop_submit(<?= $id ?>,'remove'); return false;"
                                                                         style="{ color: red; font-size: 8pt;}"><?= $w_shop_delete ?></A>&nbsp;
                                                        </TD>
                                                    </TR>
                                                    <TR>
                                                        <TD colspan="2">
                                                            <HR noshade>
                                                        </TD>
                                                    </TR>
                                                    </TABLE><?php if ($c == 3) {
                                                        $c = 0;
                                                        echo "</td></tr><tr><td align=\"center\" valign=\"bottom\">";
                                                    } else {
                                                        echo "</td><td align=\"center\">";
                                                    }
                                                }
                                                ?>
                                            </TD>
                                        </TR>
                                    </TABLE>
                                </TD>
                                </TR><?php } ?>
                        </table>
                    </div>
                </div>
            </dd>
            <DT><?= $w_money_opt ?></DT>
            <DD>
                <DIV class="reducer">
                    <table align="center">
                        <tr>
                            <td colspan="2" align="center"><B><?php echo $w_money; ?>
                                    :<?= $current_user->credits ?></B></td>
                        </tr>
                        <TR>
                            <td><?= $w_money_exchange ?></td>
                            <TD><INPUT type="button" class="input_button" value="�������"
                                       onClick="location.href='user_info.php?session=<?= $session ?>&op=exchange';">
                            </TD>
                        </TR>
                        <TR>
                            <td><?= $w_money_transfer ?></td>
                            <TD colspan="2">
                                <INPUT type="button" class="input_button" value="�������"
                                       onClick="location.href='user_info.php?session=<?= $session ?>&op=transfer';">
                            </TD>
                        </TR>
                    </table>
                </div>
            </dd>

            <DT><?= $w_password ?></DT>
            <DD>
                <DIV class="reducer">
                    <TABLE border="0">
                        <TR>
                            <TD colspan="2"><B><?php echo $w_if_wanna_change_password; ?></B>
                            </TD>
                        </TR>
                        <TR>
                            <TD colspan="2"><SMALL><?php echo $w_current_password; ?>.</SMALL>
                            </TD>
                        </TR>
                        <TR>
                            <TD><?php echo $w_password; ?>:
                            </TD>
                            <TD>
                                <INPUT type="password" name="old_password" class="input">
                            </TD>
                        </TR>
                        <TR>
                            <TD><I><?php echo $w_new_password; ?></I>:
                            </TD>
                            <TD>
                                <INPUT type="password" name="passwd1" class="input">
                            </TD>
                        </TR>
                        <TR>
                            <TD><?php echo $w_confirm_password; ?>:
                            </TD>
                            <TD>
                                <INPUT type="password" name="passwd2" class="input">
                            </TD>
                        </TR>
                        <?php if ($current_user->user_class == 0 and $current_user->custom_class == 0) { ?>
                        <tr>
                            <td colspan="2"><INPUT type=checkbox name="allow_pass_check"
                                                   value="1" <?php if ($current_user->allow_pass_check) echo " checked"; ?>><?= $w_pass_secutity_check ?>
                            </td>
                            <?php } ?>
                        <tr>
                            <td colspan="2" align="right">
                                <hr noshade>
                                <INPUT type="submit" value="<?php echo $w_update; ?>" class="input"></td>
                        </tr>
                    </TABLE>
                </div>
            </dd>
            <DT><?= $w_adm_reffer_menu ?></DT>
            <DD>
                <DIV class="reducer">
                    <TABLE border="0">
                        <TR>
                            <TD colspan="2"><small><?php

                                    require($file_path . "tarrifs.php");
                                    $MsgToPass = $w_adm_reffer_note;
                                    $MsgToPass = str_replace("~", $tarrifs["ref_bounty_points"], $MsgToPass);
                                    $MsgToPass = str_replace("#", $tarrifs["ref_bounty"], $MsgToPass);
                                    $MsgToPass = str_replace("*", $tarrifs["ref_pers"], $MsgToPass);

                                    echo $MsgToPass; ?></small></TD>
                        </TR>
                        <TR>
                            <TD><?php echo $w_adm_reffer_link; ?>:</TD>
                            <TD>
                                <a href="<?= $chat_url ?>registration_form.php?ref_id=<?= $is_regist ?>"><?= $chat_url ?>
                                    registration_form.php?ref_id=<?= $is_regist ?></a>
                            </TD>
                        </TR>
                        <tr>
                            <td colspan="2" align="right">
                                <hr noshade>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" align="center"><b><?= $w_adm_reffer_menu ?></b></td>
                        </tr>
                        <?php
                        for ($i = 0; $i < count($current_user->ref_arr); $i++) {
                            ?>
                            <TR>
                                <td colspan="2" align="center">
                                    <a href="<?= $chat_url ?>fullinfo.php?session=<?= $session ?>&user_id=<?= $current_user->ref_arr[$i]["id"] ?>"><?= $current_user->ref_arr[$i]["nick"] ?></a>
                                </TD>
                            </TR>
                            <?php
                        }
                        ?>
                    </TABLE>
                </div>
            </dd>
            <DT><?= $w_another_opt ?></DT>
            <DD>
                <DIV class="reducer">
                    <table>
                        <?php if ($current_user->user_class & ADM_BAN_MODERATORS) { ?>
                            <TR>
                                <TD>
                                    <?php echo $w_roz_show_admin; ?>
                                </td>
                                <td>
                                    <INPUT type=checkbox value=1
                                           name="show_admin" <?php if ($current_user->show_admin == 1) echo " checked"; ?>>
                                </TD>
                            </TR>
                            <TR>
                                <td><?php echo $w_roz_show_for_moders; ?></td>
                                <TD>
                                    <INPUT type=checkbox value=1
                                           name="show_for_moders" <?php if ($current_user->show_for_moders == 1) echo " checked"; ?>>
                                </TD>
                            </TR>
                            <TR>
                            <TD><?php echo $w_roz_show_ip ?></td>
                            <td>
                                <INPUT type=text class="input" name="show_ip"
                                       value="<?php echo $current_user->show_ip; ?>">
                            </TD>
                            </TR><?php } ?>
                        <TR>
                            <TD> &nbsp;<?php echo $w_font_face ?></td>
                            <td>
                                <SELECT class="input" name="font_face"><?php
                                    for ($i = 0; $i < count($fonts_arr); $i++) {
                                        $sel_str = "";
                                        if (intval($current_user->plugin_info["font_face"]) == $i) $sel_str = "selected";
                                        echo "<option value=\"$i\" $sel_str>" . $fonts_arr[$i] . "</option>\n";
                                    }
                                    ?>
                                </SELECT>
                            </TD>
                        </TR>
                        <TR>
                            <TD><?php echo $w_font_size ?></td>
                            <td>
                                <SELECT class="input" name="font_size"><?php
                                    for ($i = 0; $i < count($fonts_sizes_arr); $i++) {
                                        $sel_str = "";
                                        if (intval($current_user->plugin_info["font_size"]) == $i) $sel_str = "selected";
                                        echo "<option value=\"$i\" $sel_str>" . $fonts_sizes_arr[$i] . "%</option>\n";
                                    }
                                    ?>
                                </SELECT>
                            </TD>
                        </TR>
                        <tr>
                            <td colspan="2" align="right">
                                <hr noshade>
                                <INPUT type="submit" value="<?php echo $w_update; ?>" class="input"></td>
                        </tr>
                    </table>
                </div>
            </dd>
        </dl>
    </DIV>
</FORM>

<SCRIPT type="text/javascript">Make_Tabsheet();</SCRIPT>
</html>
