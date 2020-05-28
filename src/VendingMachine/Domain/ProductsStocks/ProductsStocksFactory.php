<?php
declare(strict_types=1);

namespace VendingMachine\Domain\ProductsStocks;

use VendingMachine\Domain\Coin\Coin;
use VendingMachine\Domain\Inserted\Inserted;
use VendingMachine\Domain\Product\Product;
use VendingMachine\Domain\Product\ProductFactory;

final class ProductsStocksFactory
{

    public static function buildFromArray(array $productsStocksRaw){

        $productsStocks = array_map(function (array $stock) {
            $product = ProductFactory::buildProductFromStringName($stock[0]);
            $stock = new Stock($stock[1]);
            return new ProductStock($product, $stock);
        }, $productsStocksRaw);

        return new ProductsStocks($productsStocks);
    }
}