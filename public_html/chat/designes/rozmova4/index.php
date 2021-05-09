<?php

if (!defined("_COMMON_")) {echo "stop";exit;}

?>
<!doctype html>
<html>
<head>
	<title>Amore-Chat.Net - Молодёжный чат</title>
</head>
<frameset rows="200,*"  frameborder=no framespacing=0 border=0 borderwidth=0>
  <frame src="<?php echo $chat_url; ?>/welcome.php?design=<?php echo $design; ?>&user_lang=<?php echo $user_lang;?>"
    noresize scrolling="no" marginwidth=2 marginheight=2>
  <frame src="<?php echo $chat_url; ?>/shower.php?design=<?php echo $design; ?>&user_lang=<?php echo $user_lang;?>"
    noresize marginwidth=2 marginheight=2 name="voc_shower">
</frameset>
</html>
