<?php


namespace VendingMachine\Test\Application\InsertCoin;

use PHPUnit\Framework\TestCase;

use VendingMachine\Application\BuyProduct\BuyProductCommand;
use VendingMachine\Application\BuyProduct\BuyProductHandler;


use VendingMachine\Domain\CashRegister\NotChangeFound;
use VendingMachine\Domain\Product\ProductNotFound;
use VendingMachine\Domain\ProductsStocks\NotEnoughMoneyInsertedToBuyProduct;
use VendingMachine\Domain\ProductsStocks\NotEnoughStockForProduct;
use VendingMachine\Test\Infrastructure\Repository\InMemoryProductsStocksRepository;
use VendingMachine\Test\Infrastructure\Repository\InMemoryCashRegisterRepository;
use VendingMachine\Test\Infrastructure\Repository\InMemoryInsertedRepository;

class BuyProductTest extends TestCase
{

    /** @test */
    public function it_should_return_a_product()
    {

        $insertedRepository = new InMemoryInsertedRepository('[0.25,0.10,1.0,1.0]');
        $cashRegisterRepository = new InMemoryCashRegisterRepository();
        $productsStocksRepository = new InMemoryProductsStocksRepository();

        $command = new BuyProductCommand('soda');
        $handler = new BuyProductHandler(
            $insertedRepository,
            $productsStocksRepository,
            $cashRegisterRepository
        );

        $result = $handler($command);

        $productsStocks = $productsStocksRepository->loadProductsStocks();
        $inserted = $insertedRepository->loadInserted();
        $cashRegister = $cashRegisterRepository->loadCashRegister();


        $this->assertEquals('SODA, 0.25, 0.25, 0.25, 0.1', $result.'');

        $this->assertEquals('[["juice",10],["water",10],["soda",9]]', $productsStocks->toJson());
        $this->assertEquals('[]', $inserted->toJson());
        $this->assertEquals('[[1,7],[0.25,18],[0.1,50],[0.05,100]]', $cashRegister->toJson());
    }

    /** @test */
    public function it_should_return_a_product_without_change()
    {

        $insertedRepository = new InMemoryInsertedRepository('[0.25,0.10,0.10,0.10,0.10]');
        $cashRegisterRepository = new InMemoryCashRegisterRepository();
        $productsStocksRepository = new InMemoryProductsStocksRepository();

        $command = new BuyProductCommand('water');
        $handler = new BuyProductHandler(
            $insertedRepository,
            $productsStocksRepository,
            $cashRegisterRepository
        );

        $result = $handler($command);

        $productsStocks = $productsStocksRepository->loadProductsStocks();
        $inserted = $insertedRepository->loadInserted();
        $cashRegister = $cashRegisterRepository->loadCashRegister();


        $this->assertEquals('WATER', $result.'');

        $this->assertEquals('[["juice",10],["water",9],["soda",10]]', $productsStocks->toJson());
        $this->assertEquals('[]', $inserted->toJson());
        $this->assertEquals('[[1,5],[0.25,21],[0.1,54],[0.05,100]]', $cashRegister->toJson());
    }

    /** @test */
    public function it_should_buy_a_juice()
    {

        $insertedRepository = new InMemoryInsertedRepository('[0.25,0.25,0.25,0.25,0.10]');
        $cashRegisterRepository = new InMemoryCashRegisterRepository();
        $productsStocksRepository = new InMemoryProductsStocksRepository();

        $command = new BuyProductCommand('JUICE');
        $handler = new BuyProductHandler(
            $insertedRepository,
            $productsStocksRepository,
            $cashRegisterRepository
        );

        $result = $handler($command);

        $productsStocks = $productsStocksRepository->loadProductsStocks();
        $inserted = $insertedRepository->loadInserted();
        $cashRegister = $cashRegisterRepository->loadCashRegister();


        $this->assertEquals('JUICE, 0.1', $result.'');

        $this->assertEquals('[["juice",9],["water",10],["soda",10]]', $productsStocks->toJson());
        $this->assertEquals('[]', $inserted->toJson());
        $this->assertEquals('[[1,5],[0.25,24],[0.1,50],[0.05,100]]', $cashRegister->toJson());
    }


    /** @test */
    public function it_should_buy_a_water_and_not()
    {

        $insertedRepository = new InMemoryInsertedRepository('[0.25,0.25,0.25,0.10]');
        $cashRegisterRepository = new InMemoryCashRegisterRepository();
        $productsStocksRepository = new InMemoryProductsStocksRepository();

        $command = new BuyProductCommand('water');
        $handler = new BuyProductHandler(
            $insertedRepository,
            $productsStocksRepository,
            $cashRegisterRepository
        );

        $result = $handler($command);

        $productsStocks = $productsStocksRepository->loadProductsStocks();
        $inserted = $insertedRepository->loadInserted();
        $cashRegister = $cashRegisterRepository->loadCashRegister();


        $this->assertEquals('WATER, 0.1, 0.1', $result.'');

        $this->assertEquals('[["juice",10],["water",9],["soda",10]]', $productsStocks->toJson());
        $this->assertEquals('[]', $inserted->toJson());
        $this->assertEquals('[[1,5],[0.25,23],[0.1,49],[0.05,100]]', $cashRegister->toJson());
    }

    /**
     * This case is special, we should implement a new algorithm to get a change in this case, we leave
     * it for the next version
     */
    /** @test */
    public function it_should_throw_an_exception_because_we_didint_insert_right_a_change()
    {
        $this->expectException(NotChangeFound::class);
        $insertedRepository = new InMemoryInsertedRepository('[1.0,0.25,0.10,0.10]');
        $cashRegisterRepository = new InMemoryCashRegisterRepository('[
                              [0.05, 0],
                              [0.10, 50],
                              [0.25, 20],
                              [1.0, 5]
                            ]');
        $productsStocksRepository = new InMemoryProductsStocksRepository();

        $command = new BuyProductCommand('water');
        $handler = new BuyProductHandler(
            $insertedRepository,
            $productsStocksRepository,
            $cashRegisterRepository
        );

        $handler($command);
    }


    /** @test */
    public function it_should_throw_an_exception_because_not_product_stock()
    {
        $this->expectException(NotEnoughStockForProduct::class);
        $insertedRepository = new InMemoryInsertedRepository('[1.0,0.25,0.10,0.10]');
        $cashRegisterRepository = new InMemoryCashRegisterRepository();
        $productsStocksRepository = new InMemoryProductsStocksRepository('[
                              ["juice", 10],
                              ["water", 0],
                              ["soda", 10]
                            ]');

        $command = new BuyProductCommand('water');
        $handler = new BuyProductHandler(
            $insertedRepository,
            $productsStocksRepository,
            $cashRegisterRepository
        );

        $handler($command);
    }


    /** @test */
    public function it_should_throw_an_exception_because_we_dident_insert_eneugh_cash()
    {
        $this->expectException(NotEnoughMoneyInsertedToBuyProduct::class);
        $insertedRepository = new InMemoryInsertedRepository('[0.25]');
        $cashRegisterRepository = new InMemoryCashRegisterRepository();
        $productsStocksRepository = new InMemoryProductsStocksRepository();

        $command = new BuyProductCommand('JUICE');
        $handler = new BuyProductHandler(
            $insertedRepository,
            $productsStocksRepository,
            $cashRegisterRepository
        );

        $handler($command);
    }

    /** @test */
    public function it_should_throw_an_exception_because_the_product_doesnt_exist()
    {
        $this->expectException(ProductNotFound::class);
        $insertedRepository = new InMemoryInsertedRepository();
        $cashRegisterRepository = new InMemoryCashRegisterRepository();
        $productsStocksRepository = new InMemoryProductsStocksRepository();

        $command = new BuyProductCommand('COKE');
        $handler = new BuyProductHandler(
            $insertedRepository,
            $productsStocksRepository,
            $cashRegisterRepository
        );

        $handler($command);
    }

}
