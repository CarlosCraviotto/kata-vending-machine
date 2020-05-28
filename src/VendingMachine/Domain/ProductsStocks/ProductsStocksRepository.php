<?php
declare(strict_types=1);


namespace VendingMachine\Domain\ProductsStocks;


interface ProductsStocksRepository
{
    public function loadProductsStocks(): ProductsStocks;
    public function saveProductsStocks(ProductsStocks $inserted): void;
}