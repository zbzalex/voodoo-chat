<?php

include($file_path . "designes/" . $design . "/common_title.php");

?>
    <script>
        function buy(itemID, is_present) {
            document.submiter.item.value = itemID;
            document.submiter.present.value = is_present;
            document.submiter.submit();
        }
    </script>
<?php

include($file_path . "designes/" . $design . "/common_body_start.php");

$counted_array = array();
$counted_vip = 0;

while (list($id, $item_class) = @each($item_list)) {
    $cur_item = $item_class;
    if (empty($category_list[$cur_item->category])) {
        $cur_item->category = 0;
        $item_list[$id]->category = 0;
    }
    $counted_array[$cur_item->category] = $counted_array[$cur_item->category] + 1;
    if ($cur_item->vip == 1)
        $counted_vip++;
}
if (strlen($type) <= 0) $type = 0;

?>
    <form name="submiter" action="shop_submit.php" method="post">
        <input type="Hidden" name="item">
        <input type="Hidden" name="session" value="<?php echo $session; ?>">
        <input type="Hidden" name="present" value="0">
    </form>
    <table width="100%">
        <tr>
            <td colspan="2" align="center"><font size=+2 color="#7E9B16"><strong> <?php echo $shop; ?></strong></font>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center"><strong><?= $w_shop_you_have ?>
                    : <?= $current_user->credits . " " . $w_money; ?></strong></td>
        </tr>
        <tr>
            <td width="100" valign="top">
                <table width="100%" border="0">
                    <?php
                    @reset($category_list);
                    while (list($id, $title) = @each($category_list)) {
                        ?>
                        <tr>
                            <td><?php if ($type == $id) echo "<li>"; ?></td>
                            <td nowrap><a href="shop.php?type=<?= $id ?>&session=<?= $session ?>"><?= $title ?>
                                    (<?php if (empty($counted_array[$id])) echo 0; else echo $counted_array[$id]; ?>
                                    )</a>
                            </td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td><?php if ($type == -2) echo "<li>"; ?></td>
                        <td nowrap><a href="shop.php?type=-2&session=<?= $session ?>"><font
                                        color="#ff0000"><?= $shop_vip ?>
                                    (<?php if (empty($counted_vip)) echo 0; else echo $counted_vip; ?>)</font></a></td>
                    </tr>
                    <tr>
                        <td><?php if ($type == "0") echo "<li>"; ?></td>
                        <td nowrap><a href="shop.php?type=0&session=<?= $session ?>"><?= $w_shop_other ?>
                                (<?php if (empty($counted_array[0])) echo 0; else echo $counted_array[0]; ?>)</a></td>
                    </tr>
                    <tr>
                        <td><?php if ($type == -1) echo "<li>"; ?></td>
                        <td nowrap><a href="shop.php?type=-1&session=<?= $session ?>"><?= $w_shop_all ?>
                                (<?= count($item_list); ?>)</a></td>
                    </tr>
                </table>
            </td>
            <td align="center" valign="top">
                <table align="center">
                    <?php

                    @reset($item_list);
                    $count_showed_items = 0;
                    while (list($id, $item_class) = @each($item_list))
                        if ($item_class->category == $type || $type == -1 || (($item_class->vip == 1) && ($type == -2))) {
                            $cur_item = $item_class;
                            $count_showed_items++;
                            ?>
                            <tr>
                                <td width="100" height="100" valign="top" nowrap align="center">
                                    <img
                                            src="<?php echo $cur_item->image; ?>" border="1"></td>
                                <td><strong><?= $shop_title ?>: <?= $cur_item->title; ?></strong><br>
                                    <strong><?= $shop_price ?>: <?= $cur_item->price . " " . $w_money; ?></strong><br>
                                    <?php if ($cur_item->vip != 1) {
                                        ?>
                                        <strong><?= "VIP " . $shop_price ?>
                                            : <?= intval(($cur_item->price - ($cur_item->price / 100) * $tarrifs["vip_discount"])) . " " . $w_money; ?></strong>
                                        <br>
                                        <?php
                                    } ?>
                                    <strong><?= $shop_quantity ?>
                                        : <?php if ($cur_item->quantity == -1) echo $shop_quantity_unlimited; else echo $cur_item->quantity ?></strong><br>
                                    <?php

                                    if ($cur_item->vip == 1) {
                                        if ($current_user->is_member) {
                                            if ($current_user->credits >= $cur_item->price && $cur_item->quantity != 0) {
                                                ?><strong><input class="input_button" type="Button"
                                                                 value="<?= $w_shop_buy ?>"
                                                                 onclick="buy(<?= $id ?>,0);">&nbsp;<input
                                                        type="Button" class="input_button"
                                                        value="<?= $w_shop_present ?>"
                                                        onclick="buy(<?= $id ?>,1);"></strong><?php
                                            } ?>
                                            <?php
                                        } else {
                                            //User not VIP
                                            echo "<strong><font color=\"#ff0000\">$shop_vip</font></strong>";
                                        }
                                    } else {
                                        if ($current_user->is_member)
                                            $price = intval(($cur_item->price - ($cur_item->price / 100) * $tarrifs["vip_discount"]));
                                        else
                                            $price = $cur_item->price;
                                        if ($current_user->credits >= $price && $cur_item->quantity != 0) {
                                            ?><strong>
                                            <form method="POST"><input class="input_button" type="Button"
                                                                       value="<?= $w_shop_buy ?>"
                                                                       onclick="buy(<?= $id ?>,0);">&nbsp;<input
                                                        type="Button" class="input_button"
                                                        value="<?= $w_shop_present ?>"
                                                        onclick="buy(<?= $id ?>,1);"></form></strong><?php
                                        } ?>
                                        <?php
                                    } ?>
                                </td>
                            </tr>
                            <?php
                        }
                    if ($count_showed_items == 0) {
                        ?>
                        <tr><?php
                            switch ($type) {
                                case 0:
                                    $str_to_out = $w_shop_other;
                                    break;
                                case -1:
                                    $str_to_out = $w_shop_all;
                                    break;
                                case -2:
                                    $str_to_out = $shop_vip;
                                    break;
                                default:
                                    $str_to_out = $category_list[$type];
                                    break;
                            }
                            ?>
                            <td colspan="2" align="center" valign="middle"><font
                                        color="#ff0000"><strong><?php echo $w_shop_category_empty; ?>.</strong></font>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
            </td>
        </tr>
    </table>

<?php

include($file_path . "designes/" . $design . "/common_body_end.php");

