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