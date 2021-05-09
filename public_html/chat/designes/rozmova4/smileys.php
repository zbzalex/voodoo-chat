<?php

require_once __DIR__ . "/../../inc_common.php";

#for determining design:
include($engine_path."users_get_list.php");
$pic_phrases = array();
$pic_urls = array();
include($ld_engine_path."pictures.php");

if (!defined("_COMMON_")) {echo "stop";exit;}

include($file_path."designes/".$design."/common_title.php");
include($file_path."designes/".$design."/common_browser_detect.php");
include($file_path."designes/".$design."/common_body_start.php");

set_variable("session");

$UserUID = -1;

for ($i=0;$i<count($users);$i++) {
        $user_array = explode("\t",$users[$i]);
        if ($user_array[USER_SESSION] == $session) {
          $UserUID = $user_array[USER_REGID];
      break;
        }
}


        include_once($file_path."admin/config.php");

        define("C_DB_NAME", DB_NAME);
        define("C_DB_USER", DB_USER);
        define("C_DB_PASS", DB_PASS);

        try {
                $pdo = new PDO("mysql:host=127.0.0.1;dbname=" . DB_NAME, DB_USER, DB_PASS);
        
        

// Displaying user-defined set
$st = $pdo->prepare("SELECT s_name, url FROM smileys WHERE uid = '$UserUID';");
$result = $st->execute();

$MaxSmileys = $result->rowCount();

if(!$MaxSmileys) { // if no user-defined smileys, loading the master set
        $st = $pdo->prepare("SELECT s_name, url FROM smileys WHERE uid = '-1';");
        $st->execute();

        $MaxSmileys = $result->rowCount();

    $UserUID = -1;
}

if(isset($SmTbl)) unset($SmTbl);

for($i = 0; $i < $MaxSmileys; $i++) {
        list($name, $url) = $DbLink->next_record();
        $SmTbl[$i]["name"] = $name;
          $SmTbl[$i]["url"] =  $url;
}

echo "<div align=CENTER>";

if($UserUID == -1) {
for ($i=0;$i<count($SmTbl);$i++)
          echo "<a href=\"javascript:addPic('".$SmTbl[$i]["name"]."');\" target=\"voc_sender\"><img src=\"".$SmTbl[$i]["url"]."\" border=0></a>\n";
}
else {
for ($i=0;$i<count($SmTbl);$i++)
          echo "<a href=\"javascript:addPic('".$SmTbl[$i]["name"]."');\" target=\"voc_sender\">".$SmTbl[$i]["url"]."</a>\n";
}

if($UserUID != -1) { // adding a master set after user-defined
        $st = $pdo->prepare("SELECT s_name, url FROM smileys WHERE uid = '-1';");
        $result = $st->execute();
        $MaxSmileys = $result->rowCount();

    if(isset($SmTbl)) unset($SmTbl);

        for($i = 0; $i < $MaxSmileys; $i++) {
                //list($name, $url) = $DbLink->next_record();
                //$SmTbl[$i]["name"] = $name;
                //  $SmTbl[$i]["url"] =  $url;
        }

        for ($i=0;$i<count($SmTbl);$i++)
                  echo "<a href=\"javascript:addPic('".$SmTbl[$i]["name"]."');\" target=\"voc_sender\"><img src=\"".$SmTbl[$i]["url"]."\" border=0></a>\n";
}

} catch(PDOException $e) {

}

echo "</div>";

include($file_path."designes/".$design."/common_body_end.php");?>