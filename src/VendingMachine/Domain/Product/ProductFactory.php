<?php
declare(strict_types=1);


namespace VendingMachine\Domain\Product;


use VendingMachine\Domain\Coin\CoinNotFound;

final class ProductFactory
{
    private static $productsClasses = [
        'VendingMachine\Domain\Product\Juice',
        'VendingMachine\Domain\Product\Soda',
        'VendingMachine\Domain\Product\Water'
    ];

    static function buildProductFromStringName(string $productName){
        $productName = strtolower($productName);

        foreach (self::$productsClasses as $Class) {
            if (constant($Class . '::NAME') === $productName) {
                return new $Class();
            }
        }

        throw new ProductNotFound($productName);
    }
}