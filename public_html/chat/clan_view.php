<?php

require_once __DIR__ . "/../../vendor/autoload.php";
require_once __DIR__ . "/inc_common.php";

$request = \Symfony\Component\HttpFoundation\Request::createFromGlobals();

set_variable("action");

include($file_path . "designes/" . $design . "/clan_view.php");
