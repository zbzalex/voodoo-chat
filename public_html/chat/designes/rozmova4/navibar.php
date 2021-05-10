<html>
<head>
    <script>
        function open_win(win_file, win_title) {
            window.open(win_file, win_title, 'resizable=yes,width=850,height=550,toolbar=no,scrollbars=yes,location=no,menubar=no,status=no');
        }
    </script>
    <style>
        a {
            font-family: Verdana, Arial;
            font-size: 10px;
            color: #3D4976;
            font-weight: bold;
            text-decoration: none;
        }

        a:hover {
            color: white
        }
    </style>
</head><body bgcolor="#ffb900" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0"
      background="<?php echo $current_design; ?>img/top_green_menu.jpg">
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0"
       background="<?php echo $current_design; ?>grunge/grunge_02.gif">
    <tr align="center">
        <td width="10%">
            <a href="/chat/shop.php?session=<?php echo $session; ?>" target="_blank">
                Магазин
            </a>
        </td>
        <td width="10%">
            <a href="/chat/board_list.php?session=<?php echo $session; ?>" target="_blank">
                Offline PM
            </a>
        </td>
        <td width="10%">
            <a href="/chat/users.php?session=<?php echo $session; ?>" target="_blank">
                Мы!
            </a>
        </td>
        <td width="10%">
            <a href="/chat/clan_view.php?session=<?php echo $session; ?>" target="_blank">
                Кланы
            </a>
        </td>

        <?php if (!$is_regist_complete) { ?>
            <td width="10%">
                <a href="/chat/registration_form.php?session=<?php echo $session; ?>" target="_parent">
                    Регистрация
                </a>
            </td>
        <?php } else { ?>
            <td width="10%">
                <a href="/chat/user_info.php?session=<?php echo $session; ?>" target="_blank">
                    Профиль
                </a>
            </td>

            <?php if ($current_user->user_class == "admin") { ?>
                <td width="10%">
                    <a href="/chat/admin.php?session=<?php echo $session; ?>" target="_blank">
                        Админка
                    </a>
                </td>
                <?php
            }

            if ($current_user->custom_class & CST_PRIEST) { ?>
                <td width="10%">
                    <a href="/chat/admin_work.php?op=marry&session=<?php echo $session; ?>">
                        ЗАГС :-)
                    </a>
                </td>
            <?php }

            if ($current_user->clan_class > 0 and $current_user->clan_id > 0) { ?>
                <td width="10%">
                    <a href="/chat/clan.php?session=<?php echo $session; ?>" target="_blank">
                        Клан
                    </a>
                </td>
            <?php }

        } ?>
        <td width="10%">
            <a href="/chat/logout.php?session=<?php echo $session; ?>" target="_parent">
                Выход
            </a>
        </td>
    </tr>
</table>
</body>
</html>