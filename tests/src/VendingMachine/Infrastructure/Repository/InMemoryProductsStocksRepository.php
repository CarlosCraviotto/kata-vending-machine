<?php
declare(strict_types=1);

namespace VendingMachine\Test\Infrastructure\Repository;


use VendingMachine\Domain\ProductsStocks\ProductsStocksRepository;
use VendingMachine\Domain\ProductsStocks\ProductsStocks;
use VendingMachine\Domain\ProductsStocks\ProductsStocksFactory;


final class InMemoryProductsStocksRepository extends InMemoryRepository implements ProductsStocksRepository
{
    protected $defaultData = '[
                              ["juice", 10],
                              ["water", 10],
                              ["soda", 10]
                            ]';

    public function loadProductsStocks(): ProductsStocks
    {
        $fileContent = $this->loadData();
        return ProductsStocksFactory::buildFromArray($fileContent);
    }

    public function saveProductsStocks(ProductsStocks $products): void
    {
        $productsJson = $products->toJson();
        $this->saveContentToFile($productsJson);
    }

}