<?php

$user_id = $win_id;
$user_id = str_replace("Cht_Private_", "", $user_id);
$user_id = intval($user_id);

?>
<script language="javascript">
    var arrExCmd = new Array;
    var arrExCmdSize = 0;

    var nTimerRing = 0;
    //some functions kindly given by AVANPORT Studio
    var nNav = 0;
    var isIECompatible = 0;
    var isMaxthon = 0;
    var nTimerGiveMe = 0;
    var nTimerSmileys = 0;
    var smFrameOk = 0;
    var WhisperWith = "";
    var voc_channels_ok = 0;

    function checkNavigator() {
    }

    function mringdrop() {
        nTimerRing = 0;
    }

    function mring(nMilli, cTime) {

        for (i = 0; i < arrExCmdSize; i++) {
            if (arrExCmd[i].Type == 'ring' && arrExCmd[i].timeEx == cTime) return;
        }

        arrExCmd[arrExCmdSize] = {Type: 'ring', timeEx: cTime};
        arrExCmdSize++;

        if (nTimerRing)
            return;
        if (parent.self.moveBy) {
            nTimerRing = setTimeout("mringdrop()", nMilli * 1000);
            parent.self.focus();

            while (nMilli > 0) {
                for (i = 10; i > 0; i--) {
                    for (j = 2; j > 0; j--) {
                        parent.self.moveBy(0, i);
                        parent.self.moveBy(i, 0);
                        parent.self.moveBy(0, -i);
                        parent.self.moveBy(-i, 0);
                    }
                }
                nMilli = nMilli - 1;
            }
        }
    }

    function RunSysCmd(cmdLine, cType, cTime) {

        for (i = 0; i < arrExCmdSize; i++) {
            if (arrExCmd[i].Type == cType && arrExCmd[i].timeEx == cTime) return;
        }

        arrExCmd[arrExCmdSize] = {Type: cTime, timeEx: cTime};
        arrExCmdSize++;

        eval(cmdLine);
    }

    function addPic(What) {
        window.frames['voc_sender'].document.forms[0].mesg.value = window.voc_sender.document.forms[0].mesg.value + What;
        window.frames['voc_sender'].document.forms[0].mesg.focus();
    }

    function Whisper(What) {
        <?php
        if($allow_multiply) {
        if($current_user->use_old_paste == 0) { ?>
        var prev = window.frames['voc_sender'].document.forms[0].whisper.value;
        var box = window.frames['voc_sender'].document.forms[0].whisper;

        if (box.value.indexOf(What) != -1) return;

        if (prev == '' ||
            What == '<?php echo $sw_usr_all_link ?>' ||
            What == '<?php echo $w_rob_name; ?>' ||
            What == '<?php echo $sw_usr_adm_link ?>' ||
            What == '<?php echo $sw_usr_boys_link ?>' ||
            What == '<?php echo $sw_usr_girls_link ?>' ||
            What == '<?php echo $sw_usr_they_link ?>' ||
            What == '<?php echo $sw_usr_clan_link ?>' ||
            What == '<?php echo $sw_usr_shaman_link ?>' ||
            prev == '<?php echo $sw_usr_all_link ?>' ||
            prev == '<?php echo $sw_usr_adm_link ?>' ||
            prev == '<?php echo $w_rob_name; ?>' ||
            prev == '<?php echo $sw_usr_girls_link ?>' ||
            prev == '<?php echo $sw_usr_shaman_link ?>' ||
            prev == '<?php echo $sw_usr_clan_link ?>' ||
            prev == '<?php echo $sw_usr_boys_link ?>' ||
            prev == '<?php echo $sw_usr_they_link ?>') box.value = What;
        else box.value = box.value + ', ' + What;
        <?php } else {  ?>
        window.frames['voc_sender'].document.forms[0].whisper.value = What;
        <?php }
        } else { ?>
        window.frames['voc_sender'].document.forms[0].whisper.value = What;
        <?php } ?>
        window.frames['voc_sender'].document.forms[0].mesg.focus();
    }

    var webcamFrameOk = 0;

    function giveMeSmileys() {

        if (!smFrameOk) {
            smFrameOk = 1;
            window.voc_sender.document.location.href = '<?php echo $current_design;?>sender_visible.php?&opcode=popup&session=<?php echo $session;?>&user_color=<?php echo $user_color; ?>';
            <?php if(!$cu_array[USER_REDUCETRAFFIC]) { ?>
            window.voc_smileys.document.location.href = '<?php echo $current_design;?>smileys.php?session=<?php echo $session;?>';
            <?php } ?>
            <?php
            $is_regist = $user_id;
            include($ld_engine_path . "users_get_object.php");

            if($current_user->allow_webcam and
        $current_user->webcam_ip != "" and
        $current_user->webcam_port > 1024) {
            ?>
            window.frames['voc_webcam'].document.location.href = '<?php echo $chat_url;?>webcam.php?session=<?=$session?>&user_id=<?=$user_id?>';
            <?php
            }
            ?>

        }
    }

    function loadInitialNick(ThsNick) {
        WhisperWith = ThsNick;
        if (document.title.indexOf(ThsNick) == -1) document.title = ThsNick + " --" + document.title;

        with (window.frames['top_top'].document) {
            open();
            write(hdrLine1 + '\n');
            write(hdrLine2 + '\n');
            write(hdrLine3 + '\n');
            write(hdrLine4 + '\n');
            write(hdrLine5 + '\n');
            write(hdrLine6 + '\n');
            write('<p align=CENTER><font color=#BCD560 size=5><b>' + ThsNick + '</b></font></p>\n');
            close();
        }
    }

    function giveMeChat() {

        if (voc_channels_ok == 0) {

            window.setTimeout("giveMeSmileys()", 3000);

            checkNavigator();
            OpenFrame('voc_shower_priv');
            voc_channels_ok = 1;

            if (!opener.top.closed) opener.top.whoAmIPopup('<?php echo $win_id; ?>');

        }
    }

    function clear_channels() {

        if (confirm("<?php echo $w_roz_clear_priv; ?>")) {
            CloseFrame('voc_shower');
            arrSizePriv = 0;
            Redraw('voc_shower_priv');
        }

    }

    function ret_sub() {
        with (window.voc_sender.document.forms[0]) {
            IsPublic.value = '0';
            act.value = '';
            whisper.value = WhisperWith;
            mesg.value = '';
            <?php if($cu_array[USER_CLASS] > 0 or $cu_array[USER_CUSTOMCLASS] != 0) { ?>
            banType.value = '';
            <?php } ?>
            mesg.focus();
        }
    }

    //nTimerGiveMe = window.setTimeout('giveMeChat()',500);

    // channels manipulation routines for php-tail and reload
    // added by DareDEVIL
    <?php if($chat_type != "js_writer") { ?>

    var arrMsgPub = new Array;
    var arrMsgPriv = new Array;
    var arrSizePub = 0;
    var arrSizePriv = 0;
    var maxSize = 45;
    var bRedrawPub = 1;
    var bRedrawPriv = 1;

    var hdrLine1 = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=windows-1251">\n';
    var hdrLine2 = '<style> body, td {font-family: Verdana, Tahoma, Arial; font-size:13 px; color:black;}a,a:visited,a:hover{ color:black;}\n';
    var hdrLine3 = 'small {font-size:11px; color:#555555;} a.nick, a.nick:visited {text-decoration: none; } a.nick:hover { color:#6060ff; text-decoration: none;}\n';
    var hdrLine4 = '.hs { background-color: #dadada; } .hu { background-color: #BDD6A9;} .ha { background-color: #FFB9A1;} .topic {  font-size:16px; font-weight:bold; color:#555555;}\n';
    var hdrLine5 = '</style>\n';
    var hdrLine6 = '<script language="javascript">\n var pause = 0;\n function up()\n {\nif (pause == 0)\n { \nscrollTo(0,10000000);\n} \n}\n </' + 'script' + '>\n</head><body bgcolor="#fafafa" marginwidth="2" marginheight="2" topmargin="2" leftmargin="2" >\n';
    var hdrEnd = '</body></html>';


    function AddMsgToPublic(nMsg, Usr) {
        var i;

        bRedrawPub = 1;

        if (nMsg.length > 0) {

            for (i = 0; i < arrSizePub; i++) {
                if (arrMsgPub[i].Msg == nMsg) return;
            }

            if (arrSizePub == maxSize) {
                Stack('pub');
                arrMsgPub[arrSizePub - 1] = {Msg: nMsg, Nick: Usr};
            } else {
                arrMsgPub[arrSizePub] = {Msg: nMsg, Nick: Usr};
                arrSizePub++;
            }
            DrawMessage('voc_shower', nMsg);
        }

    }

    function AddMsgToPriv(nMsg, Usr) {
        var i;
        var tmpHandle;
        var i = 0, idx = -1;
        var IsWindowFound = false;

        bRedrawPriv = 1;
        if (nMsg.length > 0) {

            for (i = 0; i < arrSizePriv; i++) {
                if (arrMsgPriv[i].Msg == nMsg) return;
            }

            if (arrSizePriv == maxSize) {
                Stack('priv');
                arrMsgPriv[arrSizePriv - 1] = {Msg: nMsg, Nick: Usr};
            } else {
                arrMsgPriv[arrSizePriv] = {Msg: nMsg, Nick: Usr};
                arrSizePriv++;
            }
            DrawMessage('voc_shower_priv', nMsg);


        }

    }

    function ClearPub(Nickname, cTime) {
        var i, j = 0, a;
        var tmpArr = new Array;

//if(isMaxthon) return;

        for (i = 0; i < arrExCmdSize; i++) {
            if (arrExCmd[i].Type == 'clear' && arrExCmd[i].timeEx == cTime) return;
        }

        arrExCmd[arrExCmdSize] = {Type: 'clear', timeEx: cTime};
        arrExCmdSize++;

        if (!isIECompatible) {
            <?php if ($chat_type == "tail") { ?>
            window.voc_shower.document.location.href = '<?php echo $shower;?>&t=n';
            return;
            <?php } ?>
        }

        cmp1 = Nickname.toLowerCase();

        for (i = 0; i < arrSizePub; i++) {
            cmp2 = arrMsgPub[i].Nick.toLowerCase();

            if (cmp1 != cmp2) {
                tmpArr[j] = {Nick: arrMsgPub[i].Nick, Msg: arrMsgPub[i].Msg};
                j++;
            }
        }

        for (a = 0; a < j; a++) {
            arrMsgPub[a].Nick = tmpArr[a].Nick;
            arrMsgPub[a].Msg = tmpArr[a].Msg;
        }

        arrSizePub = j;

        CloseFrame('voc_shower');
        Redraw('voc_shower');

    }

    function Stack(What) {
        var i;

        if (What == 'pub') {
            for (i = 0; i < arrSizePub - 1; i++) {
                arrMsgPub[i] = arrMsgPub[i + 1];
            }
        } else {
            for (i = 0; i < arrSizePriv - 1; i++) {
                arrMsgPriv[i] = arrMsgPriv[i + 1];
            }
        }

    }

    function OpenFrame(frameName) {
        with (window.frames[frameName].document) {
            open();
            write(hdrLine1 + '\n');
            write(hdrLine2 + '\n');
            write(hdrLine3 + '\n');
            write(hdrLine4 + '\n');
            write(hdrLine5 + '\n');
            write(hdrLine6 + '\n');
        }
    }

    function CloseFrame(frameName) {
        with (window.frames[frameName].document) {
            write(hdrEnd + '\n');
            close();
        }
    }

    function DrawMessage(frameName, Msg) {
        if (nNav == 2) {
            Redraw(frameName);
        } else {
            window.frames[frameName].document.write(Msg + '<br>');
            window.frames[frameName].document.write('<script>up();');
            window.frames[frameName].document.write('<' + '/script' + '>');
        }
    }

    function Redraw(frameName) {
        var i, idx;

        with (window.frames[frameName].document) {
            open();
            write(hdrLine1 + '\n');
            write(hdrLine2 + '\n');
            write(hdrLine3 + '\n');
            write(hdrLine4 + '\n');
            write(hdrLine5 + '\n');
            write(hdrLine6 + '\n');

            if (frameName == 'voc_shower') {
                for (i = 0; i < arrSizePub; i++) {
                    if (nNav == 2) idx = (arrSizePub - 1) - i;
                    else idx = i;

                    if (arrMsgPub[idx] != null && arrMsgPub[idx] != 'undefined') {
                        write(arrMsgPub[idx].Msg + '<br>\n');
                    }
                }
            } else {
                for (i = 0; i < arrSizePriv; i++) {

                    if (nNav == 2) idx = (arrSizePriv - 1) - i;
                    else idx = i;

                    if (arrMsgPriv[idx] != null && arrMsgPriv[idx] != 'undefined') {
                        write(arrMsgPriv[idx].Msg + '<br>\n');
                    }
                }
            }
        }

        if (nNav == 2) CloseFrame(frameName);
    }
    <?php } ?>

    //-->
</script>
<script language=VBScript>
    <!--
    Function
    RunOSWinCmd(cmdLine)
    cmdLine = Replace(cmdLine, "@", VBCrLf)
    Execute(cmdLine)
    End
    Function
    //-->
</script>
</head>
<?php if ($cu_array[USER_CLASS] > 0 or $cu_array[USER_CUSTOMCLASS] != 0) {
if ($cu_array[USER_CLASS] & ADM_BAN_BY_SUBNET and $cu_array[USER_CUSTOMCLASS] == 0) {
?>
<frameset rows="50,*,130,0" onUnload="opener.ClosePopup('<?php echo $win_id; ?>');" framespacing="1" scrolling="no"
          frameborder="YES" bordercolor="#3D4976" onLoad="giveMeChat();">
    <?php } else { ?>
    <frameset rows="50,*,100,0" onUnload="opener.ClosePopup('<?php echo $win_id; ?>');" framespacing="1" scrolling="no"
              frameborder="YES" bordercolor="#3D4976" onLoad="giveMeChat();">
        <?php }
        } else { ?>
        <frameset rows="50,*,90,0" onUnload="opener.ClosePopup('<?php echo $win_id; ?>');" framespacing="1"
                  scrolling="no" frameborder="YES" bordercolor="#3D4976" onLoad="giveMeChat();">
            <?php } ?>

            <frame name="top_top" src="<?php echo $current_design; ?>blank.html" marginwidth="0" marginheight="0"
                   scrolling="no" frameborder="0">

            <frameset cols="*,<?php if (!$cu_array[USER_REDUCETRAFFIC]) { ?> 45, <?php } ?>0,0" bordercolor="#3D4976"
                      framespacing="1" frameborder="YES" scrolling=auto>
                <frameset rows="0,*" bordercolor="#3D4976">
                    <frame name="menu" src="<?php echo $current_design; ?>blank.html" scrolling=no frameborder="0">
                    <?php
                    if ($current_user->allow_webcam and
                        $current_user->webcam_ip != "" and
                        $current_user->webcam_port > 1024) {
                        ?>
                        <frameset cols="*,350" bordercolor="#3D4976">
                            <frame name="voc_shower_priv" src="<?php echo $current_design; ?>blank.html" marginwidth="0"
                                   marginheight="0" scrolling="auto" frameborder="0">
                            <frame name="voc_webcam" src="<?php echo $current_design; ?>blank.html" marginwidth="0"
                                   marginheight="0" scrolling="no" frameborder="0">
                        </frameset>
                    <?php } else { ?>
                        <frame name="voc_shower_priv" src="<?php echo $current_design; ?>blank.html" marginwidth="0"
                               marginheight="0" scrolling="auto" frameborder="0">
                    <?php } ?>
                </frameset>
                <?php if (!$cu_array[USER_REDUCETRAFFIC]) { ?>
                    <frame src="<?php echo $current_design; ?>status_blank.php?session=<?php echo $session; ?>"
                           name="voc_smileys" marginwidth="0" marginheight="0" scrolling="auto" frameborder="0">
                <?php } ?>
            </frameset>

            <frame src="<?php echo $current_design; ?>blank.html" name="voc_sender" scrolling="no" frameborder="0">
            <frame name="voc_sender_hidden" src="" scrolling=no noresize frameborder="0">
        </frameset>
        <noframes>
        </noframes>
        <script>giveMeChat();</script>
        </html>
