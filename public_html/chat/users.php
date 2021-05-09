<?php

require_once __DIR__ . "/../../vendor/autoload.php";
require_once __DIR__ . "/inc_common.php";

$request = \Symfony\Component\HttpFoundation\Request::createFromGlobals();

/** @var string $look_for */
$look_for = $request->request->get("look_for");

include ROOT_DIR . "/data/engine/files/users_get_list.php";

$u_ids = array();
$u_names = array();
$tmp_body = "";
$tmp_subject = "";

$info_message = "";

if ($look_for != "") {
    $user_to_search = $look_for;

    include ROOT_DIR . "/data/engine/files/users_search.php";

    if (!count($u_ids)) {
        $info_message = "<b>"
            . str_replace("~", "&quot;<b>" . htmlspecialchars($look_for) . "</b>&quot;", $w_search_no_found)
            . "</b><br />";
    }
}

require_once ROOT_DIR . "/public_html/chat/designes/" . THEME . "/users.php";
