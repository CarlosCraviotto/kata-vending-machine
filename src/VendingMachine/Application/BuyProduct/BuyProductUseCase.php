<?php
declare(strict_types=1);

namespace VendingMachine\Application\BuyProduct;

use VendingMachine\Domain\CashRegister\CashRegisterRepository;

use VendingMachine\Domain\Product\Product;
use VendingMachine\Domain\Inserted\InsertedRepository;
use VendingMachine\Domain\ProductsStocks\ProductsStocksRepository;

final class BuyProductUseCase
{
    private $repository;

    /**
     * InsertCoinUseCase constructor.
     * @param $repository
     */
    public function __construct(
        InsertedRepository $insertedRepository,
        ProductsStocksRepository $productsStocksRepository,
        CashRegisterRepository $cashRegisterRepository
    )
    {
        $this->insertedRepository = $insertedRepository;
        $this->productsStocksRepository = $productsStocksRepository;
        $this->cashRegisterRepository = $cashRegisterRepository;
    }

    public function buyProduct(Product $product): BuyProductResult
    {
        list($inserted, $productsStocks, $cashRegister) = $this->getEntities();

        //get the product from the stock and calculate the cashRegister as float
        $changeAsFloat = $productsStocks->buyProduct($inserted->getTotalMoneyInserted(), $product);

        //save the coins into the cashRegister
        $changeAsCoins = $cashRegister->getChange($inserted, $changeAsFloat);

        //persist the state of the app
        $this->persistEntities($inserted, $productsStocks, $cashRegister);

        return new BuyProductResult($changeAsCoins, $product);
    }

    private function getEntities(){
        $inserted = $this->insertedRepository->loadInserted();
        $productsStocks = $this->productsStocksRepository->loadProductsStocks();
        $cashRegister = $this->cashRegisterRepository->loadCashRegister();
        return [$inserted, $productsStocks, $cashRegister];
    }

    private function persistEntities($inserted, $productsStocks, $cashRegister){
        $this->insertedRepository->saveInserted($inserted);
        $this->productsStocksRepository->saveProductsStocks($productsStocks);
        $this->cashRegisterRepository->saveCashRegister($cashRegister);
    }
}