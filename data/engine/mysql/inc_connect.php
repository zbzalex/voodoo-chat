<?php

if(!defined("_CONNECT_")):
define("_CONNECT_",1);
if (!mysql_connect("localhost", "root", "123"))
	trigger_error("Cannot connect to the database. ".mysql_error(),E_USER_ERROR);
if (!mysql_select_db("voodoo"))
	trigger_error("Cannot select database. ".mysql_error(),E_USER_ERROR);
endif;
