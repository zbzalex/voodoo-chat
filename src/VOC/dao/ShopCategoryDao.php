<?php


namespace VOC\dao;

use VOC\db\Dao;
use VOC\db\IDB;
use VOC\vo\ShopProduct;
use VOC\vo\ShopCategory;


class ShopCategoryDao extends Dao
{
    private static $TABLE = "voc2_shop_categories";

    public function getAllDeprecated()
    {
        $rows = @file(ROOT_DIR . "/items_types.dat");
        if ($rows && count($rows) > 0) {
            /** @var ShopCategory[] $entities */
            $entities = [];
            for ($i = 0; $i < count($rows); $i++) {
                $row = $rows[$i];
                $entities[] = new ShopCategory(
                    intval($row[0]),
                    $row[1]
                );
            }

            return $entities;
        }

        return null;
    }
}