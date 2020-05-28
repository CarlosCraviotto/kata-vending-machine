<?php
declare(strict_types=1);

namespace VendingMachine\Application\BuyProduct;

use VendingMachine\Domain\CashRegister\CashRegisterRepository;
use VendingMachine\Domain\Inserted\InsertedRepository;
use VendingMachine\Domain\ProductsStocks\ProductsStocksRepository;
use VendingMachine\Domain\Product\ProductFactory;

final class BuyProductHandler
{
    private $insertedRepository;
    private $productsStocksRepository;
    private $cashRegisterRepository;

    /**
     * InsertCoinHandler constructor.
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

    public function __invoke(BuyProductCommand $command): BuyProductResult
    {
        $useCase = $this->buildUseCase();
        $product = ProductFactory::buildProductFromStringName($command->getProduct());

        return $useCase->buyProduct($product);
    }

    private function buildUseCase()
    {
        return new BuyProductUseCase(
            $this->insertedRepository,
            $this->productsStocksRepository,
            $this->cashRegisterRepository
        );
    }
}