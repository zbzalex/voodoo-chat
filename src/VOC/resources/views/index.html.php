<!doctype html>
<html>
<head>
    <meta name="keywords" content=""/>
    <meta name="description" content=""/>
    <title>Amore-Chat.Net - Молодёжный чат</title>
    <style type="text/css">
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
        }

        body {
            font-family: "Liberation Mono";
            font-size: 14px;
        }

        .Canvas {
            max-width: 930px;
            height: 100%;
            margin: 0 auto;
        }

        .Layout {
            height: 100%;
        }

        .Input {
            border: 1px solid #cccccc;
            padding: 3px;
        }
    </style>
</head>
<body>
<div class="Canvas">
    <div class="Layout">
        <table style="width: 930px; background-color: #ffffff;">
            <tr>
                <td style="width: 360px"></td>
                <td style="width: 360px"></td>
                <td style="padding: 25px;">
                    <div style="text-align: center; margin-bottom: 25px;">
                        ВХОД В ЧАТ
                    </div>
                    <form action="/chat/voc.php" method="POST">
                        <table style="width: 180px; margin-top:10px; margin-bottom:10px;">
                            <tr>
                                <td style="width: 100%; padding-bottom: 10px;">
                                    <input type="text" name="user_name" style="width: 100%;" class="Input"/>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 100%; padding-bottom: 10px;">
                                    <input type="password" name="password" style="width: 100%;" class="Input"/>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <input type="submit" value="Войти"
                                           style="float:right; cursor:pointer;">
                                    <div style="padding-top:3px;">
                                        <a href="/chat/registration_form.php">Регистрация</a>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </form>
                </td>
            </tr>
        </table>
        <table style="width: 930px; padding: 25px 0 25px 0;">
            <tr>
                <td style="width: 300px; padding: 0 25px;" valign="top">

                    <table style="width: 100%;" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td align="left">КТО В ЧАТЕ?</td>
                        </tr>
                        <tr>
                            <td align="left" valign="top" style="padding-top: 25px;">
                                <table width="270" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td style="width: 30px;">
                                            №
                                        </td>
                                        <td style="width: 170px;">
                                            Ник
                                        </td>
                                        <td style="width: 70px;">

                                        </td>
                                    </tr>
                                    <?php foreach ($who as $item) { ?>
                                        <tr>
                                            <td style="width: 30px;">
                                                1
                                            </td>
                                            <td style="width: 170px;">
                                                <a href="/profile/<?php echo $item->getCanonNick(); ?>/?ref=main">
                                                    <?php echo $item->getNickname(); ?>
                                                </a>
                                            </td>
                                            <td style="width: 70px;">

                                            </td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
                <td style="width: 630px;">
                    Добро пожаловать в наш чат!!!!
                </td>
            </tr>
        </table>
    </div>
</div>
</div>
</body>
</html>