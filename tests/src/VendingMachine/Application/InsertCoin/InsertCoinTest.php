<?php


namespace VendingMachine\Test\Application\InsertCoin;

use PHPUnit\Framework\TestCase;
use VendingMachine\Application\InsertCoin\InsertCoinCommand;
use VendingMachine\Application\InsertCoin\InsertCoinHandler;

use VendingMachine\Domain\Coin\CoinNotFound;
use VendingMachine\Test\Infrastructure\Repository\InMemoryInsertedRepository;

class InsertCoinTest extends TestCase
{

    /** @test */
    public function it_should_save_one_insert()
    {
        $repository = new InMemoryInsertedRepository();
        $command = new InsertCoinCommand('0.25');
        $handler = new InsertCoinHandler($repository);

        $handler($command);

        $inserted = $repository->loadInserted();

        $this->assertEquals('[0.25]', $inserted->toJson());
    }

    /** @test */
    public function it_should_save_two_insert()
    {
        $repository = new InMemoryInsertedRepository();
        $command = new InsertCoinCommand('0.25');
        $command2 = new InsertCoinCommand('0.10');
        $handler = new InsertCoinHandler($repository);

        $handler($command);
        $handler($command2);

        $inserted = $repository->loadInserted();

        $this->assertEquals('[0.25,0.1]', $inserted->toJson());
    }


    /** @test */
    public function it_should_throw_exception_because_we_send_coin_inexistent()
    {
        $this->expectException(CoinNotFound::class);

        $command = new InsertCoinCommand('0.50');
        $handler = new InsertCoinHandler(new InMemoryInsertedRepository());

        $handler($command);
    }

}
