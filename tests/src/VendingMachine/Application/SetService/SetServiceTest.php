<?php


namespace VendingMachine\Test\Application\InsertCoin;

use PHPUnit\Framework\TestCase;



use VendingMachine\Application\SetService\NotSendAValidTypeForSetService;
use VendingMachine\Application\SetService\SetServiceCommand;
use VendingMachine\Application\SetService\SetServiceHandler;

use VendingMachine\Test\Infrastructure\Repository\InMemoryProductsStocksRepository;
use VendingMachine\Test\Infrastructure\Repository\InMemoryCashRegisterRepository;

class SetServiceTest extends TestCase
{

    /** @test */
    public function it_should_set_products()
    {

        $cashRegisterRepository = new InMemoryCashRegisterRepository();
        $productsStocksRepository = new InMemoryProductsStocksRepository();

        $command = new SetServiceCommand('products', '[["juice",2],["water",2],["soda",2]]');
        $handler = new SetServiceHandler(
            $productsStocksRepository,
            $cashRegisterRepository
        );

        $handler($command);

        $productsStocks = $productsStocksRepository->loadProductsStocks();

        $this->assertEquals('[["juice",2],["water",2],["soda",2]]', $productsStocks->toJson());
    }

    /** @test */
    public function it_should_set_change()
    {

        $cashRegisterRepository = new InMemoryCashRegisterRepository();
        $productsStocksRepository = new InMemoryProductsStocksRepository();

        $command = new SetServiceCommand('change', '[[1,0],[0.25,0],[0.1,0],[0.05,1]]');
        $handler = new SetServiceHandler(
            $productsStocksRepository,
            $cashRegisterRepository
        );

        $handler($command);

        $cashRegister = $cashRegisterRepository->loadCashRegister();

        $this->assertEquals('[[1,0],[0.25,0],[0.1,0],[0.05,1]]', $cashRegister->toJson());
    }


    /** @test */
    public function it_should_throw_an_exception_because_not_product_stock()
    {
        $this->expectException(NotSendAValidTypeForSetService::class);

        $cashRegisterRepository = new InMemoryCashRegisterRepository();
        $productsStocksRepository = new InMemoryProductsStocksRepository();

        $command = new SetServiceCommand('changes', '[]');
        $handler = new SetServiceHandler(
            $productsStocksRepository,
            $cashRegisterRepository
        );

        $handler($command);
    }


}
