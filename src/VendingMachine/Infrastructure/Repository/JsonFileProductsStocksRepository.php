<?php
declare(strict_types=1);

namespace VendingMachine\Infrastructure\Repository;


use VendingMachine\Domain\ProductsStocks\ProductsStocksRepository;
use VendingMachine\Domain\ProductsStocks\ProductsStocks;
use VendingMachine\Domain\ProductsStocks\ProductsStocksFactory;

final class JsonFileProductsStocksRepository extends JsonFileRepository implements ProductsStocksRepository
{
    protected $file = 'products_stocks.json';
    protected $defaultFile = 'default_products_stocks.json';

    public function loadProductsStocks(): ProductsStocks
    {
        $fileContent = $this->loadFileContent();
        return ProductsStocksFactory::buildFromArray($fileContent);
    }

    public function saveProductsStocks(ProductsStocks $products): void
    {
        $productsJson = $products->toJson();
        $this->saveContentToFile($productsJson);
    }

}