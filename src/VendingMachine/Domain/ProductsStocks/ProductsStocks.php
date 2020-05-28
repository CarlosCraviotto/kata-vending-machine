<?php
declare(strict_types=1);

namespace VendingMachine\Domain\ProductsStocks;

use VendingMachine\Domain\Coin\Coin;
use VendingMachine\Domain\Inserted\Inserted;
use VendingMachine\Domain\Product\Product;

final class ProductsStocks
{

    private $productsStocks;

    /**
     * ProductsStocks constructor.
     * @param $productsStocks
     */
    public function __construct(array $productsStocks)
    {
        $this->productsStocks = $productsStocks;
    }

    public function buyProduct(float $totalMoneyInserted, Product $product): float
    {
        $stock = $this->getStockForProduct($product);

        if (!$stock) {
            throw new StockForProductNotFound();
        }

        $changeAsFloat =  $stock->buyProduct($totalMoneyInserted);
        $this->updateStockProduct($stock);

        return $changeAsFloat;
    }

    public function toJson(): string
    {
        $values = (empty($this->productsStocks)) ? [] : array_map(function (ProductStock $stock) {
            return $stock->toArray();
        }, $this->productsStocks);

        return json_encode($values);
    }

    private function getStockForProduct(Product $product): ProductStock
    {
        $stock = null;
        foreach ($this->productsStocks as $productStock) {
            if ($productStock->isSameProduct($product)) {
                $stock = $productStock;
                break;
            }
        }

        return $stock;
    }

    private function updateStockProduct(ProductStock $productStockToClone): void{

        foreach ($this->productsStocks as $key=>$productStock) {
            if ($productStock->isSameProduct($productStockToClone->getProduct())) {
                $this->productsStocks[$key] = clone $productStockToClone;
                break;
            }
        }
    }
}