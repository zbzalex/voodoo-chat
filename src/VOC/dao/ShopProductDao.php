<?php


namespace VOC\dao;

use VOC\db\Dao;
use VOC\db\IDB;
use VOC\vo\ShopProduct;


class ShopProductDao extends Dao
{
    private static $TABLE = "voc2_shop_products";

    public function getAllDeprecated()
    {
        $rows = @file(ROOT_DIR . "/items.dat");
        if ($rows && count($rows) > 0) {
            /** @var ShopProduct[] $entities */
            $entities = [];
            for ($i = 0; $i < count($rows); $i++) {
                $row = $rows[$i];
                $entities[] = new ShopProduct(
                    intval($row[0]),
                    $row[1],
                    $row[2],
                    doubleval($row[3]),
                    intval($row[4]),
                    intval($row[5]),
                    intval($row[6]) === 1,
                    intval($row[7]),
                    $row[8]
                );
            }

            return $entities;
        }

        return null;
    }
}