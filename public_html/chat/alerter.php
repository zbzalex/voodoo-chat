<?php

require_once __DIR__ . "/../../vendor/autoload.php";
require_once __DIR__ . "/inc_common.php";

include($engine_path . "users_get_list.php");

if (!$exists) {
    $error_text = "$w_no_user";
    include($file_path . "designes/" . $design . "/error_page.php");
    exit;
}
if (!$is_regist_complete) {
    $error_text = "<div align=center>$w_roz_only_for_club.</div>";
    include($file_path . "designes/" . $design . "/error_page.php");
    exit;
}
include("inc_user_class.php");
include($ld_engine_path . "users_get_object.php");

include($ld_engine_path . "hidden_board_alerter.php");

?>
<!doctype html>
<html>
<head>
    <script>
        function rel() {
            document.location.href = '<?php echo $chat_url . "alerter.php?session=$session";?>';
        }

        window.setTimeout("location.reload()", 600000);

        function open_win(win_file, win_title) {
            window.open(win_file, win_title, 'resizable=yes,width=500,height=350,toolbar=no,scrollbars=yes,location=no,menubar=no,status=no');
        }
    </script>
    <noscript>
        <?php
        echo "<meta http-equiv=\"refresh\" content=\"600;URL=alerter.php?session=$session\">\n";
        ?>
    </noscript>

    <?php include($file_path . "designes/" . $design . "/common_body_start.php"); ?>

    <?php
    if (intval($new_board_messages) > 0) {
        ?>
        <script>
            alert('<?php echo $w_roz_new_message; ?>' + ' "' + '<?php echo $w_roz_offline_pm; ?>' + '"');
        </script>
        <?php

    }
    if ($current_user->user_class > 0 or
        $current_user->custom_class > 0 or
        $current_user->allow_pass_check) {

        $CanBeDone = true;
        if ($current_user->last_pass_check < my_time() - PASS_CHANGE_TIME) {

            ?>
            <script>
                alert('<?php echo $w_pass_secutity_alert ?>');
            </script>
            <?php
        }
    }

    ?>
</head>
<body></body>
</html>

