<html>
<body bgcolor="white">
<?php
include("../inc_common.php");
$users = file($user_data_file);
for ($i=0;$i<count($users);$i++)
{
	list($u_id,$nickname,$bla_bla) = explode("\t",$users[$i]);
	$nickname = strtolower($nickname);
	@rename($nickname.".big.jpg","".$u_id.".big.jpg");
	@rename($nickname.".big.gif","".$u_id.".big.gif");
	@rename($nickname.".jpg","".$u_id.".jpg");
	@rename($nickname.".gif","".$u_id.".gif");
	echo "$u_id -- $nickname finished<br>\n";
	flush();
}

?>
</body>
</html>