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

?>
<!doctype html>
<html>
<head></head>
<body>
<?php

echo $info_message;

if (count($u_ids)) {
    echo "$w_search_results<br>";
    for ($i = 0; $i < count($u_ids); $i++)
        echo "<a href=\"fullinfo.php?user_id=" . $u_ids[$i] . "&session=$session\">" . $u_names[$i] . "</a><br>\n";
}

?>

<hr>

<?php echo $w_search; ?>
<form method="post" action="users.php">
    <input type="hidden" name="session" value="<?php echo $session; ?>">
    <table border="0">
        <tr>
            <td valign="middle">
                <?php echo $w_enter_nick; ?>: <input type="text" name="look_for" class="input"></td>
            <td valign="middle">
                <input type="submit" value="<?php echo $w_search_button; ?>" class="input">
            </td>
        </tr>
    </table>
    <?php echo $w_not_shure_in_nick ?>
</form>
</body>
</html>
