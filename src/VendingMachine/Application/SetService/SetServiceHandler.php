<?php
declare(strict_types=1);

namespace VendingMachine\Application\SetService;

use VendingMachine\Application\ReturnCoins\ReturnCoinsQuery;
use VendingMachine\Application\ReturnCoins\ReturnCoinsResult;
use VendingMachine\Application\ReturnCoins\ReturnCoinsUseCase;
use VendingMachine\Domain\CashRegister\CashRegisterRepository;
use VendingMachine\Domain\Inserted\InsertedRepository;
use VendingMachine\Domain\ProductsStocks\ProductsStocksRepository;

final class SetServiceHandler
{
    private $productsStocksRepository;
    private $cashRegisterRepository;

    /**
     * InsertCoinHandler constructor.
     * @param $repository
     */
    public function __construct(
        ProductsStocksRepository $productsStocksRepository,
        CashRegisterRepository $cashRegisterRepository
    )
    {
        $this->productsStocksRepository = $productsStocksRepository;
        $this->cashRegisterRepository = $cashRegisterRepository;
    }

    public function __invoke(SetServiceCommand $command): void
    {
        $useCase = new SetServiceUseCase(
            $this->productsStocksRepository,
            $this->cashRegisterRepository
        );

        $useCase->setService($command->getType(), $command->getData());
    }

}